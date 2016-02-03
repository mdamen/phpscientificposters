<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\Role;

interface UserRepositoryInterface
{
    /**
     * @return int
     */
    public function countUsers();
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers($max = 0);
    
    /**
     * @param array $data
     *
     * @return User
     */
    public function storeUser(array $data);
    
    /**
     * @param User $user
     *
     * @return User
     */
    public function updateUser(User $user);
    
    /**
     * @param User $user
     *
     * @return void
     */
    public function deleteUser(User $user);
    
    /**
     * @param User  $user
     * @param array $rolenames
     *
     * @return void
     */
    public function syncRolesByName(User $user, array $rolenames);
    
    /**
     * @param User $user
     * @param Role $role
     *
     * @return void
     */
    public function attachRole(User $user, Role $role);
    
    /**
     * @param User $user
     * @param Role $role
     *
     * @return void
     */
    public function detachRole(User $user, Role $role);
}