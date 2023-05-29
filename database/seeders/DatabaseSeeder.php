<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\AdminDatabaseSeeder;
use Modules\Admin\Database\Seeders\AdminSeederTableSeeder;
use Modules\Admin\Database\Seeders\PermissionSeeder;
use Modules\Core\Database\Seeders\CoreDatabaseSeeder;
use Modules\Core\Database\Seeders\RoleDatabaseSeeder;
use Modules\Organizer\Database\Seeders\OrganizerDatabaseSeeder;
use Modules\SupplierApi\Database\Seeders\SupplierApiDatabaseSeeder;
use Modules\Tour\Database\Seeders\DestinationDatabaseSeeder;
use Modules\Tour\Database\Seeders\TourDatabaseSeeder;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Country;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleDatabaseSeeder::class);
        $this->call(AdminDatabaseSeeder::class);
        $this->call(TourDatabaseSeeder::class);
        $this->call(OrganizerDatabaseSeeder::class);
        $this->call(SupplierApiDatabaseSeeder::class);
    }
}
