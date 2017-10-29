<?php

namespace Models;


class CalculateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider calcPricePerMeterProvider
     * @param $expected
     * @param $price - цена за банку
     * @param $volume - объем
     * @param $consumption - расход л/м2
     */
    public function testCalcPricePerMeter($expected, $price, $volume, $consumption)
    {
        $result = Calculate::calcPricePerMeter($price, $volume, $consumption);
        $this->assertEquals($expected, $result, 'неправильная цена за м2', 0.1);
    }

    public function calcPricePerMeterProvider()
    {
        return [
            [40, 100, 5, 2],
            [34.6, 260, 15, 2],
            [12, 60, 5, 1],
        ];
    }
}
