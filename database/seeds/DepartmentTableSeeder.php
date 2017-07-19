<?php

use Illuminate\Database\Seeder;
use App\Eloquents\Department;
use DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<3; $i++)
        {
            DB::table('departments')->insert([
                'name' => str_random(10),
                'address' => str_random(10).'-Hanoi',
            ]);
        }
    }
}
