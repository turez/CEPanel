<?php

namespace App\Services;

use App\Services\CE\Adapter;

class CEService
{
    private const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    public function __construct(
        private Adapter $cEAdapter,
    ) {
    }

    public function getTopFiveProductsInProgressStatus()
    {
        $orders = $this->cEAdapter->getOrdersByStatus(self::STATUS_IN_PROGRESS, 1);

    }

    public function updateStock(string $ProductNo, int $stock)
    {
    }
}