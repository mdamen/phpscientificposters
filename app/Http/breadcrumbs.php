<?php

use App\Models\Poster;
use App\Models\User;

// Posters
Breadcrumbs::register('poster.list', function($breadcrumbs)
{
    $breadcrumbs->push('Posters', route('poster.list'));
});

// Posters > Add
Breadcrumbs::register('poster.create', function($breadcrumbs)
{
    $breadcrumbs->parent('poster.list');
    $breadcrumbs->push('Add poster', route('poster.create'));
});

// Posters > [poster]
Breadcrumbs::register('poster.details', function($breadcrumbs, Poster $poster)
{
    $breadcrumbs->parent('poster.list');
    $breadcrumbs->push($poster->title, route('poster.details', [$poster->id]));
});

// Posters > [Poster] > Edit
Breadcrumbs::register('poster.edit', function($breadcrumbs, Poster $poster)
{
    $breadcrumbs->parent('poster.details', $poster);
    $breadcrumbs->push("Edit", route('poster.edit', [$poster->id]));
});

// Posters > [poster] > Add attachment
Breadcrumbs::register('attachment.add', function($breadcrumbs, Poster $poster)
{
    $breadcrumbs->parent('poster.details', $poster);
    $breadcrumbs->push('Add attachment', route('attachment.add', [$poster->id]));
});



// User management
Breadcrumbs::register('user.list', function($breadcrumbs)
{
    $breadcrumbs->push('User management', route('user.list'));
});

// Posters > Add
Breadcrumbs::register('user.create', function($breadcrumbs)
{
    $breadcrumbs->parent('user.list');
    $breadcrumbs->push('Add user', route('user.create'));
});

// Posters > [User]
Breadcrumbs::register('user.details', function($breadcrumbs, User $user)
{
    $breadcrumbs->parent('user.list');
    $breadcrumbs->push($user->name, route('user.details', [$user->id]));
});

// Posters > [User] > Edit
Breadcrumbs::register('user.edit', function($breadcrumbs, User $user)
{
    $breadcrumbs->parent('user.details', $user);
    $breadcrumbs->push("Edit", route('user.edit', [$user->id]));
});