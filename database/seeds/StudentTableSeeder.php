<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            ['name' => 'lai', 'sex' => 10, 'age' => 16],
            ['name' => 'fei', 'sex' => 30, 'age' => 20],
        ]);
    }
}
