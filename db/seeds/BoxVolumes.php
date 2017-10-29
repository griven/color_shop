<?php


use Phinx\Seed\AbstractSeed;

class BoxVolumes extends AbstractSeed
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
        $boxes = [
            [
                'type' => 's',
                'volume' => 5
            ],
            [
                'type' => 'm',
                'volume' => 15
            ],
            [
                'type' => 'l',
                'volume' => 30
            ],
            [
                'type' => 'xl',
                'volume' => 50
            ],
        ];

        $posts = $this->table('box_volumes');
        $posts->insert($boxes)
            ->save();
    }
}
