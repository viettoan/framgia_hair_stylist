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
        $department = new Department;
        $department->name = __('Hair Salon');
        $department->address = __('Ha Noi');
        $department->save();
    }
}
