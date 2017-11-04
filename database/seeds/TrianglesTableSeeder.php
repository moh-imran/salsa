<?php

use Illuminate\Database\Seeder;

class TrianglesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('triangles')->delete();
        
        \DB::table('triangles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'Biologi',
                'subject_id' => 1,
                'participation_warning_value' => 0.94,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-11 12:19:27',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'Engelska',
                'subject_id' => 2,
                'participation_warning_value' => 0.94,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'Fysik',
                'subject_id' => 3,
                'participation_warning_value' => 0.95,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'Geografi',
                'subject_id' => 4,
                'participation_warning_value' => 0.95,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'Kemi',
                'subject_id' => 5,
                'participation_warning_value' => 0.93,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'Matematik',
                'subject_id' => 6,
                'participation_warning_value' => 0.95,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'Religionskunskap',
                'subject_id' => 7,
                'participation_warning_value' => 0.95,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'Samhällskunskap',
                'subject_id' => 8,
                'participation_warning_value' => 0.95,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'Svenska',
                'subject_id' => 9,
                'participation_warning_value' => 0.97,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'Historia',
                'subject_id' => 10,
                'participation_warning_value' => 0.95,
                'merit_points_warning_value' => 1.19,
                'status' => 1,
                'is_free' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2017-01-04 10:02:06',
                'updated_at' => '2017-01-04 10:02:06',
            ),
        ));
        
        
    }
}