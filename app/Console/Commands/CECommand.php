<?php

namespace App\Console\Commands;

use App\Services\CEService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Throwable;

class CECommand extends Command
{
    private const ACTION_LIST_ORDERS_IN_PROGRESS = 'List Orders In Progress.';
    private const ACTION_LIST_TOP_FIVE = 'List top 5 product from the orders in progress.';
    private const ACTION_UPDATE_STOCK = 'Update a product stock to 25.';
    private const ACTION_EXIT = 'Exit.';

    protected const ACTION_MAPPING = [
        self::ACTION_LIST_ORDERS_IN_PROGRESS => 'listOrdersInProgress',
        self::ACTION_LIST_TOP_FIVE => 'listTopFive',
        self::ACTION_UPDATE_STOCK => 'updateProductStock',
        self::ACTION_EXIT => null,
    ];

    public function __construct(
        private CEService $cEService,
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ce:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interact with CE API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Welcome to CE client.');
        do {
            $this->info('Main Menu');
            $choice = $this->choice(
                'What would you like to do?',
                $this->getMenuChoices()
            );

            if ($choice !== self::ACTION_EXIT) {
                try {
                    $action = self::ACTION_MAPPING[$choice];
                    $this->{$action}();
                } catch (Throwable $throwable) {
                    $this->error($throwable->getMessage());
                }
            }
        } while ($choice !== self::ACTION_EXIT);

        $this->info('Bye');
    }

    private function listOrdersInProgress(): void
    {
        $page = 1;
        do {
            $orders = $this->cEService->getOrdersInProgress($page);
            $this->table(
                ['Order No', 'Date', 'Status', 'GTIN', 'Product No', 'Name', 'Quantity', 'Total Price'],
                $this->formatOrdersForTable($orders->items())
            );
            if ($orders->hasMorePages()) {
                $this->ask('Press enter to continue.');
                $page++;
            }
        } while ($orders->hasMorePages());
    }

    private function listTopFive(): void
    {
        $topProducts = $this->cEService->getTopFiveProductsInProgressStatus();
        $this->table(
            ['GTIN', 'Name', 'Total Quantity'],
            $topProducts
        );
    }

    private function updateProductStock(): void
    {
        $productNo = $this->ask('Insert Product No');
        $this->validatePrompt($productNo, ['string', 'max:255']);

        $success = $this->cEService->updateToDefaultStock($productNo);

        if ($success) {
            $this->info("Product stock successfully updated.");
        } else {
            $this->error("Failed to update stock.");
        }
    }

    private function getMenuChoices()
    {
        return array_combine(range(1, count(self::ACTION_MAPPING)), array_keys(self::ACTION_MAPPING));
    }

    private function formatOrdersForTable(array $orders): array
    {
        $orderLines = [];
        foreach ($orders as $order) {
            foreach ($order['orderLines'] as $orderLine) {
                $orderLines[] = [
                    $order['orderNo'],
                    $order['createdAt'],
                    $orderLine['status'],
                    $orderLine['gtin'],
                    $orderLine['productNo'],
                    $orderLine['productName'],
                    $orderLine['quantity'],
                    $orderLine['totalIncVat'],
                ];
            }
        }
        return $orderLines;
    }
}
