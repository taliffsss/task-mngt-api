<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskStatus::insert([
            [
                'name' => "Todo",
                'is_active' => true,
            ],
            [
                'name' => "In Progress",
                'is_active' => true,
            ],
            [
                'name' => "Completed",
                'is_active' => true,
            ],
        ]);
    }
}
