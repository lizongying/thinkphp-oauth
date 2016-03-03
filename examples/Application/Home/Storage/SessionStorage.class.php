<?php

namespace Home\Storage;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\SessionInterface;

class SessionStorage extends AbstractStorage implements SessionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $result = M('oauth_sessions')
                            ->field('oauth_sessions.id, oauth_sessions.owner_type, oauth_sessions.owner_id, oauth_sessions.client_id, oauth_sessions.client_redirect_uri')
                            ->join('LEFT JOIN oauth_access_tokens ON oauth_access_tokens.session_id = oauth_sessions.id')
                            ->where(array('oauth_access_tokens.access_token'=>$accessToken->getId()))
                            ->select();

        if (count($result) === 1) {
            $session = new SessionEntity($this->server);
            $session->setId($result[0]['id']);
            $session->setOwner($result[0]['owner_type'], $result[0]['owner_id']);

            return $session;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        $result = M('oauth_sessions')
                            ->field('oauth_sessions.id, oauth_sessions.owner_type, oauth_sessions.owner_id, oauth_sessions.client_id, oauth_sessions.client_redirect_uri')
                            ->join('LEFT JOIN oauth_auth_codes ON oauth_auth_codes.session_id = oauth_sessions.id')
                            ->where(array('oauth_auth_codes.auth_code'=>$authCode->getId()))
                            ->select();

        if (count($result) === 1) {
            $session = new SessionEntity($this->server);
            $session->setId($result[0]['id']);
            $session->setOwner($result[0]['owner_type'], $result[0]['owner_id']);

            return $session;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(SessionEntity $session)
    {
        $result = M('oauth_sessions')
                            ->field('oauth_scopes.*')
                            ->join('LEFT JOIN oauth_session_scopes ON oauth_sessions.id = oauth_session_scopes.session_id')
                            ->join('LEFT JOIN oauth_scopes ON oauth_scopes.id = oauth_session_scopes.scope')
                            ->where(array('oauth_sessions.id'=>$session->getId()))
                            ->select();

        $scopes = [];

        foreach ($result as $scope) {
            $scopes[] = (new ScopeEntity($this->server))->hydrate([
                'id'            =>  $scope['id'],
                'description'   =>  $scope['description'],
            ]);
        }

        return $scopes;
    }

    /**
     * {@inheritdoc}
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $id = M('oauth_sessions')
                        ->add(array(
                            'owner_type'  =>    $ownerType,
                            'owner_id'    =>    $ownerId,
                            'client_id'   =>    $clientId,
                        ));

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        M('oauth_session_scopes')
                            ->add(array(
                                'session_id'    =>  $session->getId(),
                                'scope'         =>  $scope->getId(),
                            ));
    }
}
