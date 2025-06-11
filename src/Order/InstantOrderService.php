<?php

namespace Avanti\Order;

use Avanti\Client;
use GuzzleHttp\Exception\GuzzleException;

class InstantOrderService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取订单列表
     * @throws GuzzleException
     */
    public function getList(array $params = []): array
    {
        $response = $this->client->get('/cgi/v1/instant-orders', [
            'query' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 获取订单详情
     * @throws GuzzleException
     */
    public function getDetail(int $id): array
    {
        $response = $this->client->get("/cgi/v1/instant-orders/{$id}");
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 根据订单编号获取订单详情
     * @throws GuzzleException
     */
    public function getDetailByNo(string $no): array
    {
        $response = $this->client->get("/cgi/v1/instant-orders/no/{$no}");
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建订单
     * @throws GuzzleException
     */
    public function create(array $data): array
    {
        $response = $this->client->post('/cgi/v1/instant-orders', $data);
        return json_decode($response->getBody()->getContents(), true);
    }
} 