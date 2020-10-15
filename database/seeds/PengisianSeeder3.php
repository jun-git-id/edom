<?php

use App\Custom\CustomFunction;
use Illuminate\Database\Seeder;

class PengisianSeeder3 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomFunction::seedMhs(672,336);
    }
}
