<?php

namespace Home\Storage;


use League\OAuth2\Server\Entity\RefreshTokenEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\RefreshTokenInterface;

class RefreshTokenStorage extends AbstractStorage implements RefreshTokenInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($token)
    {
        $result = M('oauth_refresh_tokens')
                            ->where(array('refresh_token'=>$token))
                            ->select();

        if (count($result) === 1) {
            $token = (new RefreshTokenEntity($this->server))
                        ->setId($result[0]['refresh_token'])
                        ->setExpireTime($result[0]['expire_time'])
                        ->setAccessTokenId($result[0]['access_token']);

            return $token;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function create($token, $expireTime, $accessToken)
    {
        M('oauth_refresh_tokens')
                    ->add(array(
                        'refresh_token'     =>  $token,
                        'access_token'    =>  $accessToken,
                        'expire_time'   =>  $expireTime,
                    ));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RefreshTokenEntity $token)
    {
        M('oauth_refresh_tokens')
                            ->where(array('refresh_token'=>$token->getId()))
                            ->delete();
    }
}
