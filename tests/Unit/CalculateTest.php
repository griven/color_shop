<?php

namespace Calc;


class CalculateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider calcPricePerLiter
     * @param $expected
     * @param $price - цена за банку
     * @param $volume - объем
     */
    public function testCalcPricePerLiter($expected, $price, $volume)
    {
        $result = Calculate::calcPricePerLiter($price, $volume);
        $this->assertEquals($expected, $result, 'неправильная цена за м2', 0.1);
    }

    public function calcPricePerLiter()
    {
        return [
            [20, 100, 5],
            [17.3, 260, 15],
            [12, 60, 5],
        ];
    }

    /**
     * Тестирование сортировки товаров
     */
    public function testSortGoods()
    {
        $goods = [
            ['size' => 'm'],
            ['size' => 'xl'],
            ['size' => 'l'],
            ['size' => 's'],
        ];
        $result = Calculate::sortGoods($goods);

        $this->assertEquals(
            [
                ['size' => 's'],
                ['size' => 'm'],
                ['size' => 'l'],
                ['size' => 'xl'],
            ],
            $result
        );
    }

    /**
     * Проверяем фильтрацию по цене
     */
    public function testFilterByPrice()
    {
        $goods = [
            ['size' => 's', 'price' => 5],
            ['size' => 'm', 'price' => 15],
            ['size' => 'l', 'price' => 10],
            ['size' => 'xl', 'price' => 20],
        ];

        $result = Calculate::filterByPrice($goods);

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
        $goods = [
            ['size' => 's', 'pricePerLiter' => 5, 'volume' => 5],
            ['size' => 'm', 'pricePerLiter' => 3, 'volume' => 15],
            ['size' => 'l', 'pricePerLiter' => 4, 'volume' => 30],
            ['size' => 'xl', 'pricePerLiter' => 2, 'volume' => 50],
        ];

        $result = Calculate::filterByPricePerLiter($goods);

        $this->assertEquals(
            [
                ['size' => 's', 'pricePerLiter' => 5, 'volume' => 5],
                ['size' => 'm', 'pricePerLiter' => 3, 'volume' => 15],
                ['size' => 'xl', 'pricePerLiter' => 2, 'volume' => 50],
            ],
            $result
        );
    }
}
