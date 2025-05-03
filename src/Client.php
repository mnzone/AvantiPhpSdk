<?php

namespace Avanti;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private GuzzleClient $client;
    private string $baseUri;
    private ?string $accessToken = null;

    public function __construct(string $baseUri)
    {
        $this->baseUri = rtrim($baseUri, '/');
        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function setAccessToken(string $token): void
    {
        $this->accessToken = $token;
    }

    /**
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        if ($this->accessToken) {
            $options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        return $this->client->request($method, $uri, $options);
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $uri, array $data = []): ResponseInterface
    {
        return $this->request('POST', $uri, ['json' => $data]);
    }

    /**
     * @throws GuzzleException
     */
    public function put(string $uri, array $data = []): ResponseInterface
    {
        return $this->request('PUT', $uri, ['json' => $data]);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(string $uri): ResponseInterface
    {
        return $this->request('DELETE', $uri);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $uri): ResponseInterface
    {
        return $this->request('GET', $uri);
    }
} 