<?php

namespace App\Security;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class GenericUser implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;
    protected $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response['email'];
    }

    public function toArray()
    {
        return $this->response;
    }
}