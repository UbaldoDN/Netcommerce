<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_users_with_tasks_and_companies(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();
        $user3 = \App\Models\User::factory()->create();
        $company1 = \App\Models\Company::factory()->create();
        $company2 = \App\Models\Company::factory()->create();

        $task = \App\Models\Task::factory()->create([
            'user_id' => $user1->id,
            'company_id' => $company1->id,
            'is_completed' => true,
            'expired_at' => null
        ]);

        \App\Models\Task::factory()->create([
            'user_id' => $user2->id,
            'company_id' => $company2->id
        ]);
        
        $response = $this->get('/api/users');
        
        $response
            ->assertOk()
            ->assertJsonCount(3)
            ->assertJsonFragment(['name' => $user1->name])
            ->assertJsonFragment(['name' => $user2->name])
            ->assertJsonFragment(['name' => $user3->name])
            ->assertJsonFragment(['name' => $company1->name])
            ->assertJsonFragment(['name' => $company2->name])
            ->assertJsonFragment(['name' => $task->name, 'description' => $task->description, 'is_completed' => 1, 'expired_at' => null]);
    }

    public function test_store_user(): void
    {
        $response = $this->post('/api/users', ['name' => 'User 1']);
        $response
            ->assertCreated()
            ->assertJsonFragment(['name' => 'User 1'])
            ->assertJsonStructure(['id', 'name']);
        $this->assertDatabaseHas('users', ['name' => 'User 1']);
    }

    public function test_put_user(): void
    {
        $user = \App\Models\User::factory()->create();
        $response = $this->put("/api/users/{$user->id}", ['name' => 'User 2']);
        $response->assertNoContent();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'User 2']);
    }

    public function test_show_user(): void
    {
        $user = \App\Models\User::factory()->create();
        $company = \App\Models\Company::factory()->create();
        $task = \App\Models\Task::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
        \App\Models\Task::factory()->count(4)->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);

        $response = $this->get("/api/users/{$user->id}");
        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonFragment(['name' => $task->name, 'description' => $task->description, 'is_completed' => 0]);
    }

    public function test_delete_user(): void
    {
        $user = \App\Models\User::factory()->create();
        $response = $this->delete("/api/users/{$user->id}");
        $response->assertNoContent();
        $this->assertModelMissing($user);
    }
}
