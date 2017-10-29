<?php


use Phinx\Seed\AbstractSeed;

class Consumption extends AbstractSeed
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
        $posts = $this->table('consumption');
        $posts->insert(['consumption' => 1])
            ->save();

    }
}
