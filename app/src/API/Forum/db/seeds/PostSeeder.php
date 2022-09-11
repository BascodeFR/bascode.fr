<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
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
            'created_at' => date('Y-m-d H:i:s', $date),
            'user_id' => 2,
            'updated_at' => date('Y-m-d H:i:s', $date),
            'number_of_posts' => rand(0, 3000)
            ];
        }
        $this->table('threads')
        ->insert($data)
        ->save();
    }
}
