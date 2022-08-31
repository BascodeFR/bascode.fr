<?php


use Phinx\Seed\AbstractSeed;

class NewsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [];
        $faker = \Faker\Factory::create('fr_FR');
        $date = $faker->unixTime('now');
        for ($i =0; $i < 100; ++$i) {
            $data[] =[
            'name' => $faker->catchPhrase,
            'slug' => $faker->slug,
            'content' => $faker->paragraph(3, true),
            'avatar' => 'default_thumb.png',
            'created_at' => date('Y-m-d H:i:s', $date),
            'updated_at' => date('Y-m-d H:i:s', $date)
            ];
        }
        $this->table('news')
        ->insert($data)
        ->save();
    }
}
