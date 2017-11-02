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
        $shopName = 'alpha';
        $goods = $this->getBestShopSet($needLiters, $shopName);
        $totalPrice = '-';
        $pricePerMeter = '-';
        $remain = '-';

        return compact('squareMeters', 'consumption', 'needLiters', 'shopName', 'goods', 'totalPrice', 'pricePerMeter', 'remain');
    }

    public function getBestShopSet(int $liters, string $shopName)
    {
        $this->recalculatePricePerLiter(); // это дергается вообще отдельно, но для примера сойдет
        $goods = $this->dao->getGoods($shopName);
        return (new ShopSet($goods))->filterByPrice()->filterByPricePerLiter()->getBestSet($liters);

    }
}