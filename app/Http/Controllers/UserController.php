<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserAddFormRequest;
use App\Repositories\User\UserRepositoryInterface;

use App\Models\User;
use App\Models\Role;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $repository
     *
     * @return Illuminate\View\View
     */
    public function index(UserRepositoryInterface $repository)
    {
        $users = $repository->getUsers(15);
        
        return view('user.list', compact('users'));
    }
    
    /**
     * @param User $user
     *
     * @return Illuminate\View\View
     */
    public function details(User $user)
    {
        return view('user.details', compact('user'));
    }
    
    /**
     * @return Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }
    
    /**
     * @param User $user
     *
     * @return Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }
    
    /**
     * @param UserAddFormRequest      $request
     * @param UserRepositoryInterface $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(UserAddFormRequest $request, UserRepositoryInterface $repository)
    {
        // retrieve roles array
        $roles = $request->input('roles');
        
        // check if input is array
        if (!is_array($roles)) {
            throw new \RuntimeException('$roles must be an array.');
        }
        
        // set user properties and save
        $userdata = [
            'name'     => $request->input('name'),
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];
        $user = $repository->storeUser($userdata);
        
        // sync roles
        $repository->syncRolesByName($user, $roles);

        // flash message to session
        $request->session()->flash('success', trans('user.flash.added'));
        
        return redirect(route('user.details', [$user->id]));
    }
    
    /**
     * @param UserFormRequest         $request
     * @param UserRepositoryInterface $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserFormRequest $request, UserRepositoryInterface $repository, User $user)
    {
        // retrieve roles array
        $roles = $request->input('roles');
        
        // check if input is array
        if (!is_array($roles)) {
            throw new \RuntimeException('$roles must be an array.');
        }
        
        // set user properties and update
        $user->name      = $request->input('name');
        $user->username  = $request->input('username');
        
        // if password is specified, update
        if (!empty($request->input('password'))) {
            $user->setPassword($request->input('password'));
        }
        
        $repository->updateUser($user);
        
        // sync roles
        $repository->syncRolesByName($user, $roles);
        
        // flash message to session
        $request->session()->flash('success', trans('user.flash.updated'));
        
        return redirect(route('user.details', [$user->id]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param UserRepositoryInterface  $repository
     * @param User                     $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, UserRepositoryInterface $repository, User $user)
    {
        // check if deletion is allowed
        if ($user->username == 'admin' || $user->username == Auth::user()->username) {
            throw new \RuntimeException(trans('user.flash.cannot_delete_user'));
        }
        
        // delete user
        $repository->deleteUser($user);
        
        // flash message to session
        $request->session()->flash('error', trans('user.flash.removed'));
        
        return redirect(route('user.list'));
    }
}