<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name     = 'admin';
        $user->username = 'admin';
        $user->password = bcrypt('password');
        $user->save();
        

        $admin = new Role();
        $admin->name            = 'admin';
        $admin->display_name    = 'Administrator'; // optional
        $admin->description     = 'User is allowed to manage and edit other users'; // optional
        $admin->save();
        
        $editor = new Role();
        $editor->name           = 'editor';
        $editor->display_name   = 'Poster editor'; // optional
        $editor->description    = 'User is the allowed to manage posters'; // optional
        $editor->save();
        
        
        $createPoster = new Permission();
        $createPoster->name = 'create-poster';
        $createPoster->save();

        $editPoster = new Permission();
        $editPoster->name = 'edit-poster';
        $editPoster->save();
        
        $deletePoster = new Permission();
        $deletePoster->name = 'delete-poster';
        $deletePoster->save();
        
        $uploadFile = new Permission();
        $uploadFile->name = 'upload-file';
        $uploadFile->save();
        
        $deleteFile = new Permission();
        $deleteFile->name = 'delete-file';
        $deleteFile->save();
        
        
        $createUser = new Permission();
        $createUser->name = 'create-user';
        $createUser->save();

        $editUser = new Permission();
        $editUser->name = 'edit-user';
        $editUser->save();
        
        $deleteUser = new Permission();
        $deleteUser->name = 'delete-user';
        $deleteUser->save();
        

        $admin->attachPermissions(array($createUser, $editUser, $deleteUser));
        $editor->attachPermissions(array($createPoster, $editPoster, $deletePoster, $uploadFile, $deleteFile));
        
        $user->attachRole($admin);
        $user->attachRole($editor);
    }
}
