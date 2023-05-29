<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\Core\Entities\Permission;
use Modules\User\Enum\UserType;

class PermissionRepository implements PermissionRepositoryContract
{
    public function __construct(private readonly Permission $model) {}


    /**
     * @param string $name
     * @return Permission
     */
    public function create(string $name): Permission
    {
        $objQuery = $this->model->newQuery();
        $objPermission = $objQuery->create([
            'name' => $name,
            "permission_uuid" => Str::uuid()
        ]);
        return $objPermission;
    }


    /**
     * @return Collection|null
     */
    public function getPermissions(): ?Collection
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->latest()->get();
    }

    /**
     * @param string $id
     * @return Permission|null
     */
    public function findById(string $id): ?Permission
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function deletePermission(Permission $permission): bool
    {
        return $permission->delete();
    }


    /**
     * @param Permission $objPermission
     * @param string|null $strName
     * @return Permission
     */
    public function updatePermission(Permission $objPermission, ?string $strName = null): Permission
    {
        if (is_string($strName) && $objPermission->name !== $strName)
            $objPermission->name = $strName;
        $objPermission->update();
        return $objPermission;
    }

    /**
     * @inheritDoc
     */
    public function findByUuid(string $strUuid): ?Permission
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->wherePermissionUuid($strUuid)->first();
    }
}
