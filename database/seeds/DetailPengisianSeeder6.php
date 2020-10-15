<?php

use App\Custom\CustomFunction;
use Illuminate\Database\Seeder;

class DetailPengisianSeeder6 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomFunction::seedFill(29120,5824);
    }
}
