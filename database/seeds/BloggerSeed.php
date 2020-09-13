<?php

use Illuminate\Database\Seeder;

class BloggerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Blogger::class, 10)->create();
    }
}
