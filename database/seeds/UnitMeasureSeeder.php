<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_measurements')->insert([
            'unit' => 'kilo(s)',
            'type' => 'suffix',
        ]);

        DB::table('unit_measurements')->insert([
            'unit' => 'gram(s)',
            'type' => 'suffix',
        ]);

        DB::table('unit_measurements')->insert([
            'unit' => 'pc.',
            'type' => 'suffix',
        ]);

        DB::table('unit_measurements')->insert([
            'unit' => 'pcs.',
            'type' => 'suffix',
        ]);

        DB::table('unit_measurements')->insert([
            'unit' => 'Approximately',
            'type' => 'preffix',
        ]);
    }
}
