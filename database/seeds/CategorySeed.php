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
                'Picture' => 'https://media.macphun.com/img/uploads/customer/how-to/579/15531840725c93b5489d84e9.43781620.jpg?q=85&w=1340',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Music',
                'Alias' => 'music',
                'Picture' => 'https://media.idownloadblog.com/wp-content/uploads/2018/03/Apple-Music-icon-002.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Coding',
                'Alias' => 'coding',
                'Picture' => 'https://s30776.pcdn.co/wp-content/uploads/2020/04/AdobeStock_305233591.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Chém Gió Linh Tinh',
                'Alias' => 'chem-gio-linh-tinh',
                'Picture' => 'https://image.winudf.com/v2/image/dm4uZnJlZWFwcC5iaWtpcGNoZW1naW9fc2NyZWVuXzBfMTUzNDM3Mzg5OF8wODg/screen-0.jpg?fakeurl=1&type=.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'CateName' => 'Không có gì vui',
                'Alias' => 'khong-co-gi-vui',
                'Picture' => 'https://cuoifly.tuoitre.vn/820/0/ttc/r/2019/09/10/68419623-522633328492096-2807799273071050752-n-1568085579.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('category')->insert($data);
    }
}
