<?php


namespace Models;


class Calculate
{
    /** @var \PDO $db */
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Рассчет цены на покраску 1 м2
     *
     * @param int $price - цена за банку
     * @param int $volume - объем в литрах
     * @param int $consumption - расход литров на м2
     * @return float|int
     */
    public static function calcPricePerMeter(int $price, int $volume, int $consumption)
    {
        return $price * $consumption / $volume;
    }

    /**
     * Пересчет всем товаром цены за метр
     * необходимо на сырых данных, а также если измениться расход или цена товара
     */
    public function recalculatePricePerMeter()
    {
        $goods = $this->getGoodsPriceAndVolume();
        $consumption = $this->getConsumption();
        $updateInfo = [];
        foreach ($goods as $oneGoods) {
            $updateInfo[$oneGoods['id']] = self::calcPricePerMeter($oneGoods['price'], $oneGoods['volume'], $consumption);
        }

        $this->updatePricePerMeter($updateInfo);
    }

    /**
     * Получаем цену и объем у товаров из БД
     *
     * @return array - ['id', 'price', 'volume']
     */
    public function getGoodsPriceAndVolume()
    {
        $sql = "SELECT id,price,volume
            FROM goods as g
               JOIN box_volumes as bv
                 ON g.box_type LIKE bv.type";

        $goods = [];
        $res = $this->db->query($sql, \PDO::FETCH_ASSOC);
        foreach ($res as $row) {
            $goods[] = $row;
        }

        return $goods;
    }

    /**
     * Вынимаем расход л/м2 из БД
     *
     * @return int
     */
    public function getConsumption()
    {
        $res = $this->db->query('SELECT consumption FROM consumption LIMIT 1');
        return $res->fetchColumn();
    }

    /**
     * Обновляем цену за метр квадратный
     *
     * @param array $updateInfo - массив ['id' => 'price']
     */
    public function updatePricePerMeter(array $updateInfo)
    {
        // здесь на больших данных лучше создавать временную таблицу и делать UPDATE через неё, а не в цикле (я не успею доделать по-нормальному)
        $sql = "UPDATE goods 
            SET price_per_meter=?
            WHERE id=?";

        $query = $this->db->prepare($sql);
        foreach ($updateInfo as $id => $pricePerMeter) {
            $query->execute([$pricePerMeter, $id]);
        }
    }

    public function calcResult(float $squareMeters)
    {
        $consumption = $this->getConsumption();
        $needLiters = $squareMeters * $consumption;
        $shopName = 'alfa';
        $goods = implode(',', [5, 5]);
        $totalPrice = 200;
        $pricePerMeter = 20;
        $remain = 10;

        return compact('squareMeters', 'consumption', 'needLiters', 'shopName', 'goods', 'totalPrice', 'pricePerMeter', 'remain');
    }
}