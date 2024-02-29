<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_companies_with_tasks_and_users(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();
        $company1 = \App\Models\Company::factory()->create();
        $company2 = \App\Models\Company::factory()->create();
        $company3 = \App\Models\Company::factory()->create();

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
        
        $response = $this->get('/api/companies');
        $response
            ->assertOk()
            ->assertJsonCount(3)
            ->assertJsonFragment(['name' => $user1->name])
            ->assertJsonFragment(['name' => $user2->name])
            ->assertJsonFragment(['name' => $company1->name])
            ->assertJsonFragment(['name' => $company2->name])
            ->assertJsonFragment(['name' => $company3->name])
            ->assertJsonFragment(['name' => $task->name, 'description' => $task->description, 'is_completed' => 1, 'expired_at' => null]);
    }

    public function test_store_company(): void
    {
        $response = $this->post('/api/companies', ['name' => 'Company 1']);
        $response
            ->assertCreated()
            ->assertJsonFragment(['name' => 'Company 1'])
            ->assertJsonStructure(['id', 'name']);
        $this->assertDatabaseHas('companies', ['name' => 'Company 1']);
    }

    public function test_put_company(): void
    {
        $company = \App\Models\Company::factory()->create();
        $response = $this->put("/api/companies/{$company->id}", ['name' => 'Company 2']);
        $response->assertNoContent();
        $this->assertDatabaseHas('companies', ['id' => $company->id, 'name' => 'Company 2']);
    }

    public function test_show_company(): void
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

        $response = $this->get("/api/companies/{$company->id}");
        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $company->name])
            ->assertJsonFragment(['name' => $task->name, 'description' => $task->description, 'is_completed' => 0]);
    }

    public function test_delete_company(): void
    {
        $company = \App\Models\Company::factory()->create();
        $response = $this->delete("/api/companies/{$company->id}");
        $response->assertNoContent();
        $this->assertModelMissing($company);
    }

    public function test_search_company(): void
    {
        $company = \App\Models\Company::factory()->create([
            'name' => 'Company 1'
        ]);
        \App\Models\Company::factory()->create();
        \App\Models\Company::factory()->create();
        \App\Models\Company::factory()->create();
        $response = $this->get("/api/companies/?name=Company 1");
        $response
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['name' => 'Company 1']);
    }
}
