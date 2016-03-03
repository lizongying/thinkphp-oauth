<?php

namespace Home\Storage;

use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AuthCodeInterface;

class AuthCodeStorage extends AbstractStorage implements AuthCodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($code)
    {
        $where['auth_code'] = array('eq', $code);
        $where['expire_time'] = array('egt', time());
        $result = M('oauth_auth_codes')
            ->where($where)
            ->select();

        if (count($result) === 1) {
            $token = new AuthCodeEntity($this->server);
            $token->setId($result[0]['auth_code']);
            $token->setRedirectUri($result[0]['client_redirect_uri']);
            $token->setExpireTime($result[0]['expire_time']);

            return $token;
        }

        return;
    }

    public function create($token, $expireTime, $sessionId, $redirectUri)
    {
        M('oauth_auth_codes')
            ->add(array(
                'auth_code' => $token,
                'client_redirect_uri' => $redirectUri,
                'session_id' => $sessionId,
                'expire_time' => $expireTime,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(AuthCodeEntity $token)
    {
        $result = M('oauth_auth_code_scopes')
            ->field('oauth_scopes.id, oauth_scopes.description')
            ->join('LEFT JOIN oauth_scopes ON oauth_auth_code_scopes.scope = oauth_scopes.id')
            ->where(array('auth_code' => $token->getId()))
            ->select();

        $response = [];

        if (count($result) > 0) {
            foreach ($result as $row) {
                $scope = (new ScopeEntity($this->server))->hydrate([
                    'id' => $row['id'],
                    'description' => $row['description'],
                ]);
                $response[] = $scope;
            }
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function associateScope(AuthCodeEntity $token, ScopeEntity $scope)
    {
        M('oauth_auth_code_scopes')
            ->add(array(
                'auth_code' => $token->getId(),
                'scope' => $scope->getId(),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(AuthCodeEntity $token)
    {
        M('oauth_auth_codes')
            ->where(array('auth_code' => $token->getId()))
            ->delete();
    }
}
