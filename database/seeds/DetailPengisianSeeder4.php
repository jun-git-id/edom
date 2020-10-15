<?php

use App\Custom\CustomFunction;
use Illuminate\Database\Seeder;

class DetailPengisianSeeder4 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomFunction::seedFill(17472,5824);
    }
}
