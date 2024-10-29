<?php

namespace App\Services\CE;

class Adapter
{
    public function __construct(
        private Client $cEClient,
    ) { 
    }

    public function getOrdersByStatus(string $statuses, int $page): array {

        $response = $this->cEClient->makeRequest(
            'get',
            'v2/orders',
            ['statuses' => $statuses, 'page' => $page],
        );

        return $response;
    }

    public function updateStock(string $ProductNo, int $stock)
    {

    }
}