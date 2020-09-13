<?php

use Illuminate\Database\Seeder;

class PostsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        //
        factory(\App\Post::class, 40)->create();
    }
}
