<?php


namespace Calc;


class Calculate
{
    private $dao;

    public function __construct(Dao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * Рассчет цены за 1 литр
     *
     * @param int $price - цена за банку
     * @param int $volume - объем в литрах
     * @return float|int
     */
    public static function calcPricePerLiter(int $price, int $volume)
    {
        return $price / $volume;
    }

    /**
     * Пересчет всем товаром цены за метр
     * необходимо на сырых данных, а также если измениться расход или цена товара
     */
    public function recalculatePricePerLiter()
    {
        $goods = $this->dao->getGoods();
        $updateInfo = [];
        foreach ($goods as $oneGoods) {
            $updateInfo[$oneGoods['id']] = self::calcPricePerLiter($oneGoods['price'], $oneGoods['volume']);
        }

        $this->dao->updatePricePerMeter($updateInfo);
    }

    public function calcResult(float $squareMeters)
    {
        $consumption = $this->dao->getConsumption();
        $needLiters = $squareMeters * $consumption;
        $shopName = 'alfa';
        $goods = implode(',', [5, 5]);
        $totalPrice = 200;
        $pricePerMeter = 20;
        $remain = 10;

        return compact('squareMeters', 'consumption', 'needLiters', 'shopName', 'goods', 'totalPrice', 'pricePerMeter', 'remain');
    }

    public function getBestShopSet(int $liters, string $shopName)
    {
        $goods = $this->dao->getGoods($shopName);
        $goods = self::sortGoods($goods);
        $goods = self::filterByPrice($goods);
        $goods = self::filterByPricePerLiter($goods);

        return $goods;
    }

    /**
     * Сортировка по размеру
     *
     * @param array $goods
     * @return array
     */
    public static function sortGoods(array $goods)
    {
        $sortedGoods = [];
        foreach ($goods as $oneGoods) {
            switch ($oneGoods['size']) {
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
                $sortedGoods[$position] = $oneGoods;
            }
        }

        return $sortedGoods;
    }

    /**
     * Фильтрация по цене
     *
     * @param array $sortedGoods
     * @return array
     */
    public static function filterByPrice(array $sortedGoods)
    {
        $result = [];
        $goods = array_reverse($sortedGoods);
        foreach ($goods as $oneGoods) {
            if (!isset($minPrice) || $oneGoods['price'] < $minPrice) {
                $minPrice = $oneGoods['price'];
                $result[] = $oneGoods;
            }
        }

        return array_reverse($result);
    }

    /**
     * Фильтрация по цене за литр
     *
     * @param array $sortedGoods
     * @return array
     */
    public static function filterByPricePerLiter(array $sortedGoods)
    {
        $result = [];
        foreach ($sortedGoods as $oneGoods) {
            if (!isset($bestGoods) || $oneGoods['pricePerLiter'] < $bestGoods['pricePerLiter']) {
                $bestGoods = $oneGoods;
                $result[] = $oneGoods;
            }
        }

        return $result;
    }
}