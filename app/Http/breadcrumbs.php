<?php

use App\Models\Poster;

// Posters
Breadcrumbs::register('poster.list', function($breadcrumbs)
{
    $breadcrumbs->push('Posters', route('poster.list'));
});

// Posters > Add
Breadcrumbs::register('poster.create', function($breadcrumbs)
{
    $breadcrumbs->parent('poster.list');
    $breadcrumbs->push('Add', route('poster.create'));
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