<?php

use App\Custom\CustomFunction;
use Illuminate\Database\Seeder;

class DetailPengisianSeeder5 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomFunction::seedFill(23296,5824);
    }
}
