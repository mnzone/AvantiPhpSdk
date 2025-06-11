<?php

namespace Avanti;

use Avanti\Account\AccountService;
use Avanti\Auth\AuthService;
use Avanti\Order\InstantOrderService;

class Avanti
{
    private Client $client;
    private AuthService $auth;
    private AccountService $account;
    private InstantOrderService $instantOrder;

    public function __construct(string $baseUri)
    {
        $this->client = new Client($baseUri);
        $this->auth = new AuthService($this->client);
        $this->account = new AccountService($this->client);
        $this->instantOrder = new InstantOrderService($this->client);
    }

    public function setAccessToken(string $token): void
    {
        $this->client->setAccessToken($token);
    }

    public function auth(): AuthService
    {
        return $this->auth;
    }

    public function account(): AccountService
    {
        return $this->account;
    }

    public function instantOrder(): InstantOrderService
    {
        return $this->instantOrder;
    }
} 