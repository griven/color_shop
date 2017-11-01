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
}
