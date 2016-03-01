<?php

namespace Home\Storage;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AccessTokenInterface;

class AccessTokenStorage extends AbstractStorage implements AccessTokenInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($token)
    {
//        数据库里查询access_token
        $result = M('oauth_access_tokens')
                            ->where(array('access_token'=>$token))
                            ->select();

        if (count($result) === 1) {
//            设置令牌access_token和过期时间expire_time
            $token = (new AccessTokenEntity($this->server))
                        ->setId($result[0]['access_token'])
                        ->setExpireTime($result[0]['expire_time']);

            return $token;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(AccessTokenEntity $token)
    {
        $result = M('oauth_access_token_scopes')
                                    ->field('oauth_scopes.id, oauth_scopes.description')
                                    ->join('LEFT JOIN oauth_scopes ON oauth_access_token_scopes.scope = oauth_scopes.id')
                                    ->where(array('access_token'=>$token->getId()))
                                    ->select();

        $response = [];

        if (count($result) > 0) {
            foreach ($result as $row) {
                $scope = (new ScopeEntity($this->server))->hydrate([
                    'id'            =>  $row['id'],
                    'description'   =>  $row['description'],
                ]);
                $response[] = $scope;
            }
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function create($token, $expireTime, $sessionId)
    {
        M('oauth_access_tokens')
                    ->add(array(
                        'access_token'     =>  $token,
                        'session_id'    =>  $sessionId,
                        'expire_time'   =>  $expireTime,
                    ));
    }

    /**
     * {@inheritdoc}
     */
    public function associateScope(AccessTokenEntity $token, ScopeEntity $scope)
    {
        M('oauth_access_token_scopes')
                    ->add(array(
                        'access_token'  =>  $token->getId(),
                        'scope' =>  $scope->getId(),
                    ));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(AccessTokenEntity $token)
    {
        M('oauth_access_tokens')
                    ->where(array('access_token'=>$token->getId()))
                    ->delete();
    }
}
