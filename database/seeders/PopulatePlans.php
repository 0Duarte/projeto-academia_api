<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopulatePlans extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create(['description' => 'BRONZE', 'limit' => 10]);
        Plan::create(['description' => 'PRATA', 'limit' => 20]);
        Plan::create(['description' => 'OURO', 'limit' => null]);
    }
}
