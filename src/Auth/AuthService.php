<?php

namespace Avanti\Auth;

use Avanti\Client;
use GuzzleHttp\Exception\GuzzleException;

class AuthService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取访问令牌
     * @throws GuzzleException
     */
    public function getToken(string $appId, string $appSecret, ?string $name = null, ?array $abilities = null, ?string $expiresAt = null): array
    {
        $response = $this->client->post('/cgi-bin/auth/token', [
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'name' => $name,
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 撤销访问令牌
     * @throws GuzzleException
     */
    public function revokeToken(string $token): array
    {
        $response = $this->client->post('/cgi-bin/auth/revoke', [
            'token' => $token,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 获取令牌信息
     * @throws GuzzleException
     */
    public function getTokenInfo(): array
    {
        $response = $this->client->get('/cgi-bin/auth/info');
        return json_decode($response->getBody()->getContents(), true);
    }
} 