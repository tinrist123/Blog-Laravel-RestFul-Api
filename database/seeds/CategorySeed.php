<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'CateName' => 'MyLife',
                'Alias' => 'my-life',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Music',
                'Alias' => 'music',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Coding',
                'Alias' => 'coding',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Chém Gió Linh Tinh',
                'Alias' => 'chem-gio-linh-tinh',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Không có gì vui',
                'Alias' => 'khong-co-gi-vui',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('category')->insert($data);
    }
}
