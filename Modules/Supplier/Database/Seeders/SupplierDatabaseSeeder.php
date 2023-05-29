<?php

namespace Modules\Supplier\Database\Seeders;

use Database\Seeders\SupplierApi;
use Illuminate\Database\Seeder;

class SupplierDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SupplierApi::class);
        // $this->call("OthersTableSeeder");
    }
}
