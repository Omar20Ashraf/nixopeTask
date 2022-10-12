<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Events\UserCreatedEvent;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use App\Listeners\SendEmailActivationListener;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_be_created()
    {
        $this->seed(RoleSeeder::class);

        $data = User::factory()->raw(['roles_id' => [1]]);

        $this->post('/api/user', $data)->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    /** @test */
    public function user_can_be_updated()
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->create();
        $user->name = 'name';
        $data = $user->toArray();
        $data['roles_id'] = [1];

        $this->put('/api/user/'.$user->id, $data)->assertStatus(201);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'name']);
    }

    /** @test */
    public function user_can_be_deleted()
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->create();

        $this->delete('/api/user/' . $user->id);

        $this->assertDatabaseCount('users',0);
    }

    /** @test  */
    public function a_name_is_required()
    {
        //
        $data = User::factory()->raw(['name' => '']);

        $this->post('/api/user', $data)->assertSessionHasErrors('name');
    }

    /** @test  */
    public function a_email_is_required()
    {
        $data = User::factory()->raw(['email' => '']);

        $this->post('/api/user', $data)->assertSessionHasErrors('email');
    }

    /** @test  */
    public function a_event_is_dispatched_when_user_register()
    {
        # code...
        Event::fake([UserCreatedEvent::class]);

        $this->seed(RoleSeeder::class);

        $data = User::factory()->raw(['roles_id' => [1]]);

        $this->post('/api/user', $data);

        Event::assertDispatched(UserCreatedEvent::class);
    }

    /** @test  */
    public function a_listener_is_dispatched_when_user_register()
    {
        # code...
        Event::fake([UserCreatedEvent::class]);

        $this->seed(RoleSeeder::class);

        $data = User::factory()->raw(['roles_id' => [1]]);

        $this->post('/api/user', $data);

        Event::assertListening(
            UserCreatedEvent::class,
            SendEmailActivationListener::class
        );
    }
}
