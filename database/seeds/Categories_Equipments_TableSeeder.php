<?php

use Illuminate\Database\Seeder;

class Categories_Equipments_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        		'Windows PC',
				'Mac PC',
				'マウス',
				'ヘッドセット',
				'Webカメラ',
				'ディスプレイモニター',
				'スピーカー',
				'HDMIケーブル',
				'キーボード',
			];
			
			for($i = 0; $i < count($categories); $i++){
				DB::table('categories')->insert([
					'name' => $categories[$i],
				]);
				for($j = 1; $j <= 50; $j++) {
					DB::table('equipments')->insert([
						'name' => $categories[$i] . $j,
						'category_id' => $i+1, // 注意箇所
						'status' => 0
					]);
				}
			}
    }
}
