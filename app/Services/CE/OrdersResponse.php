<?php

namespace App\Services\CE;

use DateTime;
use GuzzleHttp\Psr7\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;
use JsonException;

class OrdersResponse
{
    private LengthAwarePaginator $orders;

    public function __construct(Response $response, int $page)
    {
        $data = $this->convertResponseToArray($response);
        $orders = [];

        foreach ($data['Content'] as $item) {
            $orders[] = $this->formatOrderFromResponse($item);
        }
        
        $this->orders = new LengthAwarePaginator($orders, $data['TotalCount'], $data['ItemsPerPage'], $page);
    }

    public function getOrders()
    {
        return $this->orders;
    }

    protected function formatOrderFromResponse($item): array
    {
        $orderLines = array_map(function($orderLine) {
            return [
                'status' => $orderLine['Status'],
                'gtin' => $orderLine['Gtin'],
                'productNo' => $orderLine['MerchantProductNo'],
                'productName' => $orderLine['Description'],
                'quantity' => $orderLine['Quantity'],
                'totalIncVat' => $orderLine['LineTotalInclVat'],
            ];
        }, $item['Lines']);

        return [
            'orderNo' => $item['MerchantOrderNo'],
            'status' => $item['Status'],
            'createdAt' => (new DateTime($item['CreatedAt']))->format('Y-m-d H:i:s'),
            'orderLines' => $orderLines
        ];
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