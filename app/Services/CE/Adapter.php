<?php

namespace App\Services\CE;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use JsonException;

class Adapter
{
    public function __construct(
        private Client $cEClient,
    ) {
    }

    public function getOrdersByStatus(string $statuses, int $page): LengthAwarePaginator
    {
        $response = $this->cEClient->makeRequest(
            'get',
            'v2/orders',
            [
                'statuses' => $statuses,
                'page' => $page
            ],
        );

        $arrayResponse = $this->convertResponseToArray($response);
        $ordersResponse = new OrdersResponse($arrayResponse, $page);

        return $ordersResponse->getOrders();
    }

    public function updateStock(string $productNo, int $stock)
    {
        try {
            $response = $this->cEClient->makeRequest(
                'PUT',
                'v2/offer/stock',
                [],
                [
                    [
                        'MerchantProductNo' => $productNo,
                        'StockLocations' => [
                            [
                                'Stock' => $stock
                            ]
                        ]
                    ]
                ]
            );
        } catch (GuzzleException $exception) {
            throw $exception;
            Log::warning('Product update failed: ' . $exception->getMessage());
        }

        $objectResponse = $this->convertResponseToArray($response);

        return $objectResponse['Success'] === true && count($objectResponse['Content']) === 0;
    }

    private function convertResponseToArray(Response $response): array
    {
        try {
            return json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Response from CE is not a valid JSON');
        }
    }
}
