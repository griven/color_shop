<?php


use Phinx\Seed\AbstractSeed;

class Goods extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $goods = [
            ['box_type' => 's', 'shop_name' => 'alpha', 'price' => '100' ],
            ['box_type' => 's', 'shop_name' => 'beta', 'price' => '120' ],
            ['box_type' => 's', 'shop_name' => 'gamma', 'price' => '60' ],

            ['box_type' => 'm', 'shop_name' => 'alpha', 'price' => '260' ],
            ['box_type' => 'm', 'shop_name' => 'beta', 'price' => '300' ],
            ['box_type' => 'm', 'shop_name' => 'gamma', 'price' => '320' ],

            ['box_type' => 'l', 'shop_name' => 'alpha', 'price' => '480' ],
            ['box_type' => 'l', 'shop_name' => 'beta', 'price' => '560' ],
            ['box_type' => 'l', 'shop_name' => 'gamma', 'price' => '540' ],

            ['box_type' => 'xl', 'shop_name' => 'alpha', 'price' => '620' ],
            ['box_type' => 'xl', 'shop_name' => 'beta', 'price' => '610' ],
            ['box_type' => 'xl', 'shop_name' => 'gamma', 'price' => '615' ],
        ];

        $posts = $this->table('goods');
        $posts->insert($goods)
            ->save();
    }
}
