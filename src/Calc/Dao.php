<?php

namespace Calc;

class Dao
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Получаем цену и объем у товаров из БД
     *
     * @param string $shopName - название магазина
     * @return array
     */
    public function getGoods(string $shopName = null)
    {
        $sql = "SELECT *
            FROM goods as g
               JOIN box_volumes as bv
                 ON g.box_type LIKE bv.type";
        if ($shopName) {
            $sql .= " WHERE shop_name='$shopName'";
        }

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
            SET price_per_liter=?
            WHERE id=?";

        $query = $this->db->prepare($sql);
        foreach ($updateInfo as $id => $pricePerLiter) {
            $query->execute([$pricePerLiter, $id]);
        }
    }
}