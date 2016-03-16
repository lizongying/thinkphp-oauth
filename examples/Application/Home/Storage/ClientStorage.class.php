<?php

namespace Home\Storage;


use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\ClientInterface;

class ClientStorage extends AbstractStorage implements ClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        $where['oauth_clients.id'] = array('eq', $clientId);
        $field = 'oauth_clients.*';
        if ($clientSecret !== null) {
            $where['oauth_clients.secret'] = array('eq',  $clientSecret);
        }

        $join = '';
        if ($redirectUri) {
            $join = 'LEFT JOIN oauth_client_redirect_uris ON oauth_clients.id = oauth_client_redirect_uris.client_id';
            $where['oauth_client_redirect_uris.redirect_uri'] = array('eq',  $redirectUri);
        }

        $result = M('oauth_clients')
            ->field($field)
            ->where($where)
            ->join($join)
            ->select();

        if (count($result) === 1) {
            $client = new ClientEntity($this->server);
            $client->hydrate([
                'id'    =>  $result[0]['id'],
                'name'  =>  $result[0]['name'],
            ]);
            return $client;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySession(SessionEntity $session)
    {
        $result = M('oauth_clients')
                            ->field('oauth_clients.id, oauth_clients.name')
                            ->join('LEFT JOIN oauth_sessions ON oauth_clients.id = oauth_sessions.client_id')
                            ->where(array('oauth_sessions.id'=>$session->getId()))
                            ->select();

        if (count($result) === 1) {
            $client = new ClientEntity($this->server);
            $client->hydrate([
                'id'    =>  $result[0]['id'],
                'name'  =>  $result[0]['name'],
            ]);
            return $client;
        }

        return;
    }
}
