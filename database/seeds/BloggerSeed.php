<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;


class BloggerSeed extends Seeder
{
    /**
     * Run the databaPe seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('blogger')->insert([
            'name' => 'Ngô Hiếu Tín',
            'email' => 'tinrist123@gmail.com',
            'password' => bcrypt('bibanh'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
