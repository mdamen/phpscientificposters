<?php

use App\Models\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PosterTest extends DatabaseTestCase
{
    /**
     * Check if poster index is rendered correctly
     *
     * @return void
     */
    public function testIndex()
    {
        $this->visit('/')
            ->see(trans_choice('poster.title.posters', 2))
            ->assertViewHas('posters');
    }
    
    public function testAddPosterAuth()
    {
        $user = User::where('username', 'admin')->first();

        $this->visit('/')
            ->dontSee(trans('poster.button.add'));
        
        $this->actingAs($user)
            ->visit('/')
            ->click(trans('poster.button.add'))
            ->seePageIs('/poster/create');
    }
    
    public function testAddPoster()
    {
        $user = User::where('username', 'admin')->first();

        $this->actingAs($user)
            ->visit('/poster/create')
            ->type('Title', 'title')
            ->type('Conference', 'conference')
            ->type('2015-12-01', 'conference_at')
            ->type('test@test.com', 'contact_email')
            ->type('Test abstract', 'abstract')
            ->press(trans('poster.button.add'))
            ->see(trans('poster.flash.added'));
    }
}
