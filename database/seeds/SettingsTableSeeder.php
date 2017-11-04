<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'School Warning',
                'description' => 'Show warning at school level when there are more than X warnings on national subjects.',
                'group' => 'triangles',
                'key' => 'school_warning',
                'key_options' => '1:2:3',
                'type' => 'select',
                'value' => '2',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2017-01-06 14:40:23',
                'updated_at' => '2017-01-09 14:22:08',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Current Year',
                'description' => 'Public data files will download starting from this year.',
                'group' => 'date',
                'key' => 'current_year',
                'key_options' => 'number',
                'type' => 'number',
                'value' => '2016',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2017-01-06 14:40:18',
                'updated_at' => '2017-01-09 16:05:59',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Support E-mail',
                'description' => 'Support email address.',
                'group' => 'email',
                'key' => 'support_email',
                'key_options' => 'text',
                'type' => 'email',
                'value' => 'info@skolvalsguiden.se',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2017-01-06 14:40:18',
                'updated_at' => '2017-01-09 14:10:11',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}