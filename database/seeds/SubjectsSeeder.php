<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //National Subjects
        Subject::firstOrCreate(['title' => 'Biologi', 'use_for_deviation' => '1', 'title' => 'Biologi', 'created_by' => '1', 'updated_by' => '1']);//id = 1
        Subject::firstOrCreate(['title' => 'Engelska', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1','is_primary' => '1']);//id = 2
        Subject::firstOrCreate(['title' => 'Fysik', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1']);//id = 3
        Subject::firstOrCreate(['title' => 'Geografi', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1']);//id = 4
        Subject::firstOrCreate(['title' => 'Kemi', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1']);//id = 5
        Subject::firstOrCreate(['title' => 'Matematik', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1','is_primary' => '1']);//id = 6
        Subject::firstOrCreate(['title' => 'Religionskunskap', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1']);//id = 7
        Subject::firstOrCreate(['title' => 'Samhällskunskap', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1']);//id = 8
        Subject::firstOrCreate(['title' => 'Svenska', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1','is_primary' => '1']);//id = 9
        Subject::firstOrCreate(['title' => 'Historia', 'use_for_deviation' => '1', 'created_by' => '1', 'updated_by' => '1']);//id = 12

        Subject::firstOrCreate(['title' => 'Svenska som andraspråk', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 10
        Subject::firstOrCreate(['title' => 'Bild', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 11
        Subject::firstOrCreate(['title' => 'Hem och konsumentkunskap', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 13
        Subject::firstOrCreate(['title' => 'Idrott och hälsa', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 14
        Subject::firstOrCreate(['title' => 'Moderna språk, elevens val', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 15
        Subject::firstOrCreate(['title' => 'Moderna språk, språkval', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 16
        Subject::firstOrCreate(['title' => 'Modersmål', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 17
        Subject::firstOrCreate(['title' => 'Musik', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 18
        Subject::firstOrCreate(['title' => 'Slöjd', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 19
        Subject::firstOrCreate(['title' => 'Teknik', 'use_for_deviation' => '0', 'created_by' => '1', 'updated_by' => '1']);//id = 20
    }
}
