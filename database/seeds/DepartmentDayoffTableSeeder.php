<?php

use Illuminate\Database\Seeder;
use App\Eloquents\Department;
use App\Eloquents\TimeSheetDepartment;

class DepartmentDayoffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TimeSheetDepartment::create([
            'mon' => TimeSheetDepartment::ON_WORK,
            'tues' => TimeSheetDepartment::ON_WORK,
            'wed' => TimeSheetDepartment::ON_WORK,
            'thur' => TimeSheetDepartment::ON_WORK,
            'fri' => TimeSheetDepartment::ON_WORK,
            'sat' => TimeSheetDepartment::ON_WORK,
            'sun' => TimeSheetDepartment::ON_WORK,
        ]);
    }
}
