<?php

namespace Avanti\Account;

use Avanti\Client;
use GuzzleHttp\Exception\GuzzleException;

class AccountService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取用户access_token
     * @throws GuzzleException
     */
    public function getToken(string $username, string $password): array
    {
        $response = $this->client->post('/cgi-bin/v1/accounts/token', [
            'username' => $username,
            'password' => $password,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建用户
     * @throws GuzzleException
     */
    public function createUser(string $username, string $password, string $name, string $email): array
    {
        $response = $this->client->post('/cgi-bin/v1/accounts', [
            'username' => $username,
            'password' => $password,
            'name' => $name,
            'email' => $email,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 重置用户密码
     * @throws GuzzleException
     */
    public function resetPassword(int $userId): array
    {
        $response = $this->client->post("/cgi-bin/v1/accounts/{$userId}/reset-password");
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 设置用户密码
     * @throws GuzzleException
     */
    public function setPassword(int $userId, string $password): array
    {
        $response = $this->client->put("/cgi-bin/v1/accounts/{$userId}/password", [
            'password' => $password,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 撤销用户access_token
     * @throws GuzzleException
     */
    public function revokeToken(int $userId): array
    {
        $response = $this->client->delete("/cgi-bin/v1/accounts/{$userId}/token");
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 更新用户信息
     * @throws GuzzleException
     */
    public function updateUser(int $userId, ?string $name = null, ?string $email = null): array
    {
        $data = [];
        if ($name !== null) {
            $data['name'] = $name;
        }
        if ($email !== null) {
            $data['email'] = $email;
        }

        $response = $this->client->put("/cgi-bin/v1/accounts/{$userId}", $data);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 删除用户
     * @throws GuzzleException
     */
    public function deleteUser(int $userId): array
    {
        $response = $this->client->delete("/cgi-bin/v1/accounts/{$userId}");
        return json_decode($response->getBody()->getContents(), true);
    }
} 