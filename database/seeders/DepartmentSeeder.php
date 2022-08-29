<?php

namespace Database\Seeders;

use App\Models\Unit\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Department::factory()
            ->count(20)
            ->create();
    }
}
