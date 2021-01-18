<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mul_rows= [
            [ 'name' => 'front'],
            [ 'name' => 'back'],
            [ 'name' => 'design'],
            [ 'name' => 'management']
        ];

        foreach ($mul_rows as $rows) {
            $insert = DB::table('departments')->insert($rows);
            if ($insert) {
//success message here
            } else {
//Failure message here
            }
        }
    }
}
