<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();
        $user3 = \App\Models\User::factory()->create();

        $company1 = \App\Models\Company::factory()->create();
        $company2 = \App\Models\Company::factory()->create();
        $company3 = \App\Models\Company::factory()->create();

        \App\Models\Task::factory()->count(3)->create([
            'user_id' => $user1->id,
            'company_id' => $company1->id
        ]);

        \App\Models\Task::factory()->count(3)->create([
            'user_id' => $user2->id,
            'company_id' => $company2->id,
            'is_completed' => true,
            'expired_at' => null
        ]);

        \App\Models\Task::factory()->count(3)->create([
            'user_id' => $user3->id,
            'company_id' => $company3->id
        ]);
    }
}
