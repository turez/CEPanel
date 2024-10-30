<?php

namespace Tests\Unit;

use App\Services\CE\Adapter;
use App\Services\CEService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

class CEServiceTest extends TestCase
{
    private Adapter|Mock $cEAdapterMock;
    private CEService $sut;

    protected function setUp(): void
    {
        $this->cEAdapterMock = Mockery::mock(Adapter::class);
        $this->sut = new CEService($this->cEAdapterMock);
    }

    public function test_return_expected_top_five(): void
    {
        $this->cEAdapterMock->shouldReceive('getOrdersByStatus')
            ->with('IN_PROGRESS', 1)
            ->andReturn(
                new LengthAwarePaginator($this->getDummyOrders(1), 10, 5, 1)
            );
        $this->cEAdapterMock->shouldReceive('getOrdersByStatus')
            ->with('IN_PROGRESS', 2)
            ->andReturn(
                new LengthAwarePaginator($this->getDummyOrders(2), 10, 5, 2)
            );

        $expectedResult = [
            [
                'gtin' => '00001',
                'productName' => 'Product One',
                'totalQuantity' => 18,
            ],
            [
                'gtin' => '00002',
                'productName' => 'Product Two',
                'totalQuantity' => 12,
            ],
            [
                'gtin' => '00006',
                'productName' => 'Product Six',
                'totalQuantity' => 6,
            ],
            [
                'gtin' => null,
                'productName' => 'Product Four',
                'totalQuantity' => 4,
            ],
            [
                'gtin' => '00005',
                'productName' => 'Product Five',
                'totalQuantity' => 2,
            ]
        ];

        $this->assertSame($expectedResult, $this->sut->getTopFiveProductsInProgressStatus());
    }

    public function test_return_empy_when_no_orders(): void
    {
        $this->cEAdapterMock->shouldReceive('getOrdersByStatus')
            ->with('IN_PROGRESS', 1)
            ->andReturn(
                new LengthAwarePaginator([], 0, 5, 1)
            );

        $this->assertSame([], $this->sut->getTopFiveProductsInProgressStatus());
    }

    private function getDummyOrders(int $page): array
    {
        $orderChucks = [
            1 => [
                [
                    'orderNo' => '001',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00001',
                            'productNo' => 1,
                            'productName' => 'Product One',
                            'quantity' => 3,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
                [
                    'orderNo' => '002',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00002',
                            'productNo' => 2,
                            'productName' => 'Product Two',
                            'quantity' => 12,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
                [
                    'orderNo' => '003',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00001',
                            'productNo' => 1,
                            'productName' => 'Product One',
                            'quantity' => 3,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
                [
                    'orderNo' => '004',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00003',
                            'productNo' => 3,
                            'productName' => 'Product Three',
                            'quantity' => 1,
                            'totalIncVat' => 123
                        ],
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00006',
                            'productNo' => 6,
                            'productName' => 'Product Six',
                            'quantity' => 2,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
                [
                    'orderNo' => '005',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00001',
                            'productNo' => 1,
                            'productName' => 'Product One',
                            'quantity' => 3,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
            ],
            2 => [
                [
                    'orderNo' => '006',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00001',
                            'productNo' => 1,
                            'productName' => 'Product One',
                            'quantity' => 3,
                            'totalIncVat' => 123
                        ],
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00006',
                            'productNo' => 6,
                            'productName' => 'Product Six',
                            'quantity' => 4,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
                [
                    'orderNo' => '007',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00001',
                            'productNo' => 1,
                            'productName' => 'Product One',
                            'quantity' => 3,
                            'totalIncVat' => 123
                        ],
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00005',
                            'productNo' => 5,
                            'productName' => 'Product Five',
                            'quantity' => 2,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
                [
                    'orderNo' => '008',
                    'status' => 'IN_PROGRESS',
                    'createdAt' => '2024-01-01 11:11:11',
                    'orderLines' => [
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => '00001',
                            'productNo' => 1,
                            'productName' => 'Product One',
                            'quantity' => 3,
                            'totalIncVat' => 123
                        ],
                        [
                            'status' => 'IN_PROGRESS',
                            'gtin' => null,
                            'productNo' => 4,
                            'productName' => 'Product Four',
                            'quantity' => 4,
                            'totalIncVat' => 123
                        ]
                    ]
                ],
            ]
        ];
        return $orderChucks[$page];
    }
}
