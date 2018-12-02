<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function unaunthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies', $reply->toArray());

    }



    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        //Given we have a authenticated user
        $user = factory('App\User')->create(); 
        $this->be($user = factory('App\User')->create());

        //And en existing thread
        $thread = factory('App\Thread')->create();

        //When the user adds a reply to the thread
        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies', $reply->toArray());

        //The their reply should be included on teh page. 
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
