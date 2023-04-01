<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BonusSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('bonus_settings')->insert([


            [
                'id'=>1,
                'slug'=> 'eid_al_fitr',
                'title'=> 'Eid al-Fitr',
                'bonus_for'=> 'Islam',
                'percentage'=> 100,
                'status'=> 'active',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'=>2,
                'slug'=> 'eid_al_adha',
                'title'=> 'Eid al-Adha',
                'bonus_for'=> 'Islam',
                'percentage'=> 100,
                'status'=> 'active',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'=>3,
                'slug'=> 'durga_puja',
                'title'=> 'Durga Puja',
                'bonus_for'=> 'Hinduism',
                'percentage'=> 200,
                'status'=> 'active',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'=>4,
                'slug'=> 'buddha_s_birthday',
                'title'=> 'Buddha\'s Birthday',
                'bonus_for'=> 'Buddha',
                'percentage'=> 200,
                'status'=> 'active',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'=>5,
                'slug'=> 'christmas',
                'title'=> 'Christmas',
                'bonus_for'=> 'Christian',
                'percentage'=> 200,
                'status'=> 'active',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'=>6,
                'slug'=> 'pahela_baishakh',
                'title'=> 'Pahela Baishakh',
                'bonus_for'=> 'All',
                'percentage'=> 25,
                'status'=> 'active',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);


    }
}
