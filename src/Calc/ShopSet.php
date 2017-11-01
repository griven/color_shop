<?php


namespace Calc;


class ShopSet
{
    public $sortedGoods = [];

    public function __construct(array $goods)
    {
        $this->sortGoods($goods);
    }

    /**
     * Сортировка по размеру
     *
     * @param array $goods
     * @return $this
     */
    public function sortGoods(array $goods)
    {
        $this->sortedGoods = [];
        foreach ($goods as $oneGoods) {
            switch ($oneGoods['box_type']) {
                case 's':
                    $position = 0;
                    break;
                case 'm':
                    $position = 1;
                    break;
                case 'l':
                    $position = 2;
                    break;
                case 'xl':
                    $position = 3;
                    break;
                default:
                    $position = false;
            }
            if ($position !== false) {
                $this->sortedGoods[$position] = $oneGoods;
            }
        }
        return $this;
    }

    /**
     * Фильтрация по цене
     * @return $this
     */
    public function filterByPrice()
    {
        $result = [];
        $goods = array_reverse($this->sortedGoods);
        foreach ($goods as $oneGoods) {
            if (!isset($minPrice) || $oneGoods['price'] < $minPrice) {
                $minPrice = $oneGoods['price'];
                $result[] = $oneGoods;
            }
        }

        $this->sortedGoods = array_reverse($result);
        return $this;
    }

    /**
     * Фильтрация по цене за литр
     * @return $this
     */
    public function filterByPricePerLiter()
    {
        $result = [];
        foreach ($this->sortedGoods as $oneGoods) {
            if (!isset($bestGoods) || $oneGoods['price_per_liter'] < $bestGoods['price_per_liter']) {
                $bestGoods = $oneGoods;
                $result[] = $oneGoods;
            }
        }

        $this->sortedGoods = $result;
        return $this;
    }

    public function getBestSet($liters)
    {
        $firstSet = $this->getBestSetRecursively($liters);

        $bestSet = [];
        foreach ($firstSet as $set) {
            foreach ($set as $type => $count) {
                $bestSet[$type] = ($bestSet[$type] ?? 0) + $count;
            }
        }

        return $bestSet;
    }

    /**
     * Рекурсивно подбираем лучший набор
     * 
     * @param int $liters
     * @return array
     */
    public function getBestSetRecursively(int $liters)
    {
        $reverseGoods = array_reverse($this->sortedGoods);
        $oneGoods = [];
        foreach ($reverseGoods as $oneGoods) {
            $goodsCount = floor($liters / $oneGoods['volume']);
            if ($goodsCount) {
                $remainder = $liters - $goodsCount * $oneGoods['volume'];
                if ($remainder) {
                    $result = array_merge_recursive([[$oneGoods['type'] => $goodsCount]], $this->getBestSetRecursively($remainder));
                } else {
                    $result = [[$oneGoods['type'] => $goodsCount]];
                }
                return $result;
            }
        }

        $result = [[$oneGoods['type'] => 1]];
        return $result;
    }
}