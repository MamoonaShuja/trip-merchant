<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Enum\UserType;
class AdminSeederTableSeeder extends Seeder
{

    public function __construct(private readonly UserRepositoryContract $objUserRepository
    )
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
        $objUser = $this->objUserRepository->create(
            "Admin",
            "Admin",
            "admin@gmail.com",
            Hash::make("password"),
            "",
            "",
            "",
            "",
            "",
            UserType::ADMIN,
        );
    }
}
