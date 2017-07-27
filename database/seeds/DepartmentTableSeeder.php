<?php

use Illuminate\Database\Seeder;
use App\Eloquents\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Department::insert([
            'name' => str_random(10),
            'address' => str_random(10).'-Hanoi',
        ]);
    }
}
