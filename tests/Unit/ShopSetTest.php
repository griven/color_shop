<?php

namespace Calc;


class ShopSetTest extends \PHPUnit_Framework_TestCase
{
    /** @var ShopSet $shopSet */
    public $shopSet;

    protected function setUp()
    {
        $this->shopSet = new ShopSet([]);
    }

    /**
     * Тестирование сортировки товаров
     */
    public function testSortGoods()
    {
        $goods = [
            ['box_type' => 'm'],
            ['box_type' => 'xl'],
            ['box_type' => 'l'],
            ['box_type' => 's'],
        ];
        $result = $this->shopSet->sortGoods($goods)->sortedGoods;

        $this->assertEquals(
            [
                ['box_type' => 's'],
                ['box_type' => 'm'],
                ['box_type' => 'l'],
                ['box_type' => 'xl'],
            ],
            $result
        );
    }

    /**
     * Проверяем фильтрацию по цене
     */
    public function testFilterByPrice()
    {
        $this->shopSet->sortedGoods = [
            ['size' => 's', 'price' => 5],
            ['size' => 'm', 'price' => 15],
            ['size' => 'l', 'price' => 10],
            ['size' => 'xl', 'price' => 20],
        ];

        $result = $this->shopSet->filterByPrice()->sortedGoods;

        $this->assertEquals(
            [
                ['size' => 's', 'price' => 5],
                ['size' => 'l', 'price' => 10],
                ['size' => 'xl', 'price' => 20],
            ],
            $result
        );
    }

    /**
     * Проверяем фильтрацию по цене за литр
     */
    public function testFilterByPricePerLiter()
    {
        $this->shopSet->sortedGoods = [
            ['size' => 's', 'price_per_liter' => 5, 'volume' => 5],
            ['size' => 'm', 'price_per_liter' => 3, 'volume' => 15],
            ['size' => 'l', 'price_per_liter' => 4, 'volume' => 30],
            ['size' => 'xl', 'price_per_liter' => 2, 'volume' => 50],
        ];

        $result = $this->shopSet->filterByPricePerLiter()->sortedGoods;

        $this->assertEquals(
            [
                ['size' => 's', 'price_per_liter' => 5, 'volume' => 5],
                ['size' => 'm', 'price_per_liter' => 3, 'volume' => 15],
                ['size' => 'xl', 'price_per_liter' => 2, 'volume' => 50],
            ],
            $result
        );
    }
}
