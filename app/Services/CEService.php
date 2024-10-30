<?php

namespace App\Services;

use App\Services\CE\Adapter;
use Illuminate\Pagination\LengthAwarePaginator;

class CEService
{
    private const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    public function __construct(
        private Adapter $cEAdapter,
    ) {
    }

    public function getOrdersInProgress(int $page): LengthAwarePaginator
    {   
        return $this->cEAdapter->getOrdersByStatus(self::STATUS_IN_PROGRESS, $page);
    }

    public function getTopFiveProductsInProgressStatus(): array
    {
        $products = [];
        $page = 1;
        do {
            $orders = $this->cEAdapter->getOrdersByStatus(self::STATUS_IN_PROGRESS, $page);

            foreach ($orders as $order) {
                foreach ($order['orderLines'] as $orderLine) {
                    if (isset($products[$orderLine['productNo']])){
                        $products[$orderLine['productNo']]['totalQuantity'] += $orderLine['quantity'];
                    } else {
                        $products[$orderLine['productNo']] = [
                            'gtin' => $orderLine['gtin'],
                            'productName' => $orderLine['productName'],
                            'totalQuantity' => $orderLine['quantity'],
                        ];
                    }
                }
            }
            $page++;
        } while ($orders->hasMorePages());

        return collect($products)
            ->sortByDesc('totalQuantity')
            ->take(5)
            ->values()
            ->all();
    }

    public function updateStock(string $ProductNo, int $stock)
    {
    }
}