<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* $this->call(RolesSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(MataKuliahSeeder::class);
        $this->call(KompetensiSeeder::class);
        $this->call(PertanyaanSeeder::class); */

        /* $this->call(KelasSeeder::class);
        $this->call(MahasiswaSeeder::class);
        $this->call(DosenSeeder::class); */

        //$this->call(MengajarSeeder::class);

        //$this->call(PengisianSeeder::class);

        $this->call(DetailPengisianSeeder::class);
    }
}
