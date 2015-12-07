<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return int
     */
    public function countUsers() {
        return User::all()->count();
    }
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers($max = 0) {
        if (empty($max))
            return User::all();
        else
            return User::paginate($max);
    }
    
    /**
     * @param array $data
     *
     * @return User
     */
    public function storeUser(array $data) {
        $user = new User(
            [
                'name'          => $data['name'],
                'username'      => $data['username']
            ]
        );        
        $user->setPassword($data['password']);
        $user->save();
        
        return $user;
    }
    
    /**
     * @param User $user
     *
     * @return User
     */
    public function updateUser(User $user) {
        $user->save();
        
        return $user;
    }
    
    /**
     * @param User $user
     *
     * @return void
     */
    public function deleteUser(User $user) {
        $user->delete();
    }
    
    /**
     * @param User  $user
     * @param array $rolenames
     *
     * @return void
     */
    public function syncRolesByName(User $user, array $rolenames) {
        $roles_to_process = $this->removeRolesByName($user, $rolenames);
        $this->addRolesByName($user, $roles_to_process);
    }
    
    /**
     * @param User  $user
     * @param array $rolenames
     *
     * @return void
     */
    private function addRolesByName(User $user, array $rolenames) {
        foreach($rolenames as $rolename) {
            $role = Role::where('name', $rolename)->first();
            $this->attachRole($user, $role);
        }
    }
    
    /**
     * @param User  $user
     * @param array $rolenames
     *
     * @return array
     */
    private function removeRolesByName(User $user, array $rolenames) {
        $roles_to_process = $rolenames;
        
        // remove authors not present anymore in form
        foreach($user->roles as $role) {
            if(!in_array($role->name, $rolenames)) {
                $this->detachRole($user, $role);
            }
            
            $roles_to_process = array_diff($roles_to_process, [$role->name]);
        }
        
        return $roles_to_process;
    }
    
    /**
     * @param User $user
     * @param Role $role
     *
     * @return void
     */
    public function attachRole(User $user, Role $role) {
        $user->attachRole($role);
    }
    
    /**
     * @param User $user
     * @param Role $role
     *
     * @return void
     */
    public function detachRole(User $user, Role $role) {
        $user->detachRole($role);
    }
}