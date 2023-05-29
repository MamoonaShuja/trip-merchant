<?php

namespace Modules\Organizer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Enum\UserType;

class OrganizerDatabaseSeeder extends Seeder
{

    public function __construct(private readonly UserRepositoryContract $objUserRepository)
    {
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $objOrganization = $this->objUserRepository->create(
            "Trip",
            "Merchant",
            "tripMerchant@gmail.com",
            Hash::make("password"),
            "TM123",
            "",
            "Trip Merchant",
            "10-999",
            "",
            UserType::ORGANIZER,
        );
        $this->objUserRepository->updateActiveStatus($objOrganization , 1 , Hash::make("12345678") , "TM123" , env("DEFAULT_ORGANIZATION_DOMAIN") , null);
    }
}
