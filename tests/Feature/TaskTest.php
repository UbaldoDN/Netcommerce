<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_tasks_with_user_and_company(): void
    {
        \App\Models\Task::factory()->count(5)->create();
        $response = $this->get('/api/tasks');
        $response->assertOk()->assertJsonCount(5);
    }

    public function test_no_store_task_max_limit_uncompleted(): void
    {
        $user = \App\Models\User::factory()->create();
        $company = \App\Models\Company::factory()->create();

        \App\Models\Task::factory()->count(5)->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);

        $response = $this->post('/api/tasks', [
            'company_id' => $company->id,
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => 'Task content 1',
        ]);
        
        $response->assertConflict()->assertJsonFragment(['message' => 'No es posible crear más tareas, el máximo es de 5.']);
    }

    public function test_store_task(): void
    {
        $user = \App\Models\User::factory()->create();
        $company = \App\Models\Company::factory()->create();

        \App\Models\Task::factory()->count(4)->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);

        \App\Models\Task::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_completed' => true,
            'expired_at' => null
        ]);

        $response = $this->post('/api/tasks', [
            'company_id' => $company->id,
            'user_id' => $user->id,
            'name' => 'Task 1',
            'description' => 'Task content 1',
        ]);
        
        $response->assertCreated();
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task 1',
            'description' => 'Task content 1',
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
    }

    public function test_put_task(): void
    {
        $task = \App\Models\Task::factory()->create();
        $response = $this->put("/api/tasks/{$task->id}", ['name' => 'Tasks 2']);
        $response->assertNoContent();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => 'Tasks 2']);
    }

    public function test_show_company(): void
    {
        $user = \App\Models\User::factory()->create();
        $company = \App\Models\Company::factory()->create();
        $task = \App\Models\Task::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);

        $response = $this->get("/api/tasks/{$task->id}");
        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $company->name])
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonFragment([
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'is_completed' => 0
            ]);
    }

    public function test_delete_task_is_no_complete(): void
    {
        $user = \App\Models\User::factory()->create();
        $company = \App\Models\Company::factory()->create();
        $task = \App\Models\Task::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
        $response = $this->delete("/api/tasks/{$task->id}");
        $response->assertConflict()->assertJsonFragment(['message' => 'No es posible eliminar la tarea, no está completada.']);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
    }

    public function test_delete_task_is_complete(): void
    {
        $user = \App\Models\User::factory()->create();
        $company = \App\Models\Company::factory()->create();
        $task = \App\Models\Task::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_completed' => true,
            'expired_at' => null
        ]);
        $response = $this->delete("/api/tasks/{$task->id}");
        $response->assertNoContent();
        $this->assertModelMissing($task);
    }
}
