<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\Role;
use Modules\Core\Enum\Permissions\City as CityPermission;
use Modules\Core\Enum\Permissions\Country as CountryPermission;
use Modules\Core\Enum\Permissions\Destination as DestinationPermission;
use Modules\Core\Enum\Permissions\Subscriber as SubscriberPermission;
use Modules\Core\Enum\Permissions\TravelStyle as TravelStylePermission;
use Modules\Core\Enum\Permissions\Trip as TripPermission;
use Modules\Core\Enum\Permissions\User as UserPermission;
use Modules\Core\Enum\Permissions\Role as RolePermission;
use Modules\Core\Enum\Permissions\Permission as PermissionPermission;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Enum\UserType;

class PermissionSeeder extends Seeder
{

    public function __construct(
        private readonly PermissionRepositoryContract $objPermissionRepository,
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
        $permissions = [
            CityPermission::GET_CITIES->value,
            CityPermission::SHOW_CITY->value,
            CityPermission::STORE_CITY->value,
            CityPermission::DELETE_CITY->value,
            CityPermission::UPDATE_CITY->value,
            CountryPermission::GET_COUNTRIES->value,
            CountryPermission::SHOW_COUNTRY->value,
            CountryPermission::STORE_COUNTRY->value,
            CountryPermission::DELETE_COUNTRY->value,
            CountryPermission::UPDATE_COUNTRY->value,
            DestinationPermission::GET_DESTINATIONS->value,
            DestinationPermission::SHOW_DESTINATION->value,
            DestinationPermission::STORE_DESTINATION->value,
            DestinationPermission::DELETE_DESTINATION->value,
            DestinationPermission::UPDATE_DESTINATION->value,
            SubscriberPermission::GET_SUBSCRIBERS->value,
            SubscriberPermission::SHOW_SUBSCRIBER->value,
            SubscriberPermission::STORE_SUBSCRIBER->value,
            SubscriberPermission::DELETE_SUBSCRIBER->value,
            SubscriberPermission::UPDATE_SUBSCRIBER->value,
            TravelStylePermission::GET_TRAVEL_STYLES->value,
            TravelStylePermission::SHOW_TRAVEL_STYLE->value,
            TravelStylePermission::STORE_TRAVEL_STYLE->value,
            TravelStylePermission::DELETE_TRAVEL_STYLE->value,
            TravelStylePermission::UPDATE_TRAVEL_STYLE->value,
            TripPermission::GET_TRIPS->value,
            TripPermission::GET_DELETED_TRIPS->value,
            TripPermission::SHOW_TRIP->value,
            TripPermission::STORE_TRIP->value,
            TripPermission::DELETE_TRIP->value,
            TripPermission::GET_TRIP_QUOTES->value,
            TripPermission::SHOW_TRIP_QUOTE->value,
            TripPermission::UPDATE_TRIP_QUOTE->value,
            TripPermission::DELETE_TRIP_QUOTE->value,
            TripPermission::UPDATE_TRIP->value,
            TripPermission::UPDATE_TRIP_SLIDER->value,
            TripPermission::UPDATE_TRIP_GALLERY->value,
            TripPermission::DELETE_TRIP_GALLERY->value,
            TripPermission::DELETE_TRIP_SLIDER->value,
            UserPermission::GET_MEMBERS->value,
            UserPermission::GET_ORGANIZERS->value,
            UserPermission::GET_SUPPLIERS->value,
            UserPermission::GET_EMPLOYER->value,
            UserPermission::GET_ADMINS->value,
            UserPermission::CREATE_ADMIN->value,
            UserPermission::UPDATE_ORGANIZATION_STATUS->value,
            UserPermission::UPDATE_SUPPLIER_STATUS->value,
            UserPermission::UPDATE_PERMISSIONS->value,
            RolePermission::GET_ROLES->value,
            RolePermission::SHOW_ROLE->value,
            RolePermission::STORE_ROLE->value,
            RolePermission::DELETE_ROLE->value,
            RolePermission::UPDATE_ROLE->value,
            PermissionPermission::GET_PERMISSIONS->value,
            PermissionPermission::SHOW_PERMISSION->value,
            PermissionPermission::STORE_PERMISSION->value,
            PermissionPermission::DELETE_PERMISSION->value,
            PermissionPermission::UPDATE_PERMISSION->value,
        ];
        foreach ($permissions as $permission) {
            $this->objPermissionRepository->create(
                $permission,
            );
        }
        $permissions = $this->objPermissionRepository->getPermissions();
        $permissionIds = $permissions->pluck('id')->toArray();
        $role = Role::whereName(UserType::ADMIN->value)->first();
        $role->permissions()->sync($permissionIds);
    }
}
