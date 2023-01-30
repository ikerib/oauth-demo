<?php

namespace App\Security;

use App\Entity\User;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class OauthPasaiaProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;
    /**
     * Name of the resource owner identifier field that is
     * present in the access token response (if applicable)
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = null;

    public $auth_clientId = 'testclient';
    public $auth_clientSecret = 'testpass';
    public $auth_redirectUri = 'http://app.test:8000/callback';
    public $auth_authServer = 'https://sesamo.pasaia.net/authorize';
    public $auth_tokenServer = 'https://sesamo.pasaia.net/token';
    public $auth_jwksUri = 'https://sesamo.pasaia.net/.well-known/jwks.json';
    public $auth_apiUri = 'https://sesamo.pasaia.net/api/test';


    public function getBaseAuthorizationUrl()
    {
        return $this->auth_authServer;
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->auth_tokenServer;
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->auth_apiUri;
    }

    protected function getDefaultScopes()
    {
        return 'blog_read profile email';
    }

    protected function checkResponse(ResponseInterface $response, $data):void
    {
        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException('Providerrean arazoa');
        } elseif (isset($data['error'])) {
            throw new \RuntimeException('Providerrean2 arazoa');
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
//        $user = new GithubResourceOwner($response);

        $user = new GenericUser($response);



//        return $user->setDomain($this->domain);
        return $user;
    }
}