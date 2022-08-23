<?php


use Phinx\Seed\AbstractSeed;

class PostsSeeder extends AbstractSeed
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
        for($i =0; $i < 100; ++$i){
           $data[] =[
            'name' => $faker->catchPhrase,
            'slug' => $faker->slug,
            'author' => 0,
            'content' => $faker->text(3000),
            'created_at' => date('Y-m-d H:i:s', $date),
            'created_by' => 'admin',
            'updated_at' => date('Y-m-d H:i:s', $date),
            'total_messages' => rand(0, 3000)
           ];
        }
        $this->table('post')
        ->insert($data)
        ->save();
    }
}
