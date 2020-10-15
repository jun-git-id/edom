<?php

use App\Custom\CustomFunction;
use Illuminate\Database\Seeder;

class DetailPengisianSeeder3 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomFunction::seedFill(11648,5824);
    }
}
