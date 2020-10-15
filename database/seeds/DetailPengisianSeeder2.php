<?php

use App\Custom\CustomFunction;
use Illuminate\Database\Seeder;

class DetailPengisianSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomFunction::seedFill(5824,5824);
    }
}
