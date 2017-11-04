<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate([
            'title' => 'manage_admin_user',
            'label' => 'Manage Admin User',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_school',
            'label' => 'Manage School',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_community',
            'label' => 'Manage Community',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_grade9data',
            'label' => 'Manage Grade9 Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_import_community',
            'label' => 'Import Community Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-school',
            'label' => 'Get Schools',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-community',
            'label' => 'Get Communities',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-grade9data',
            'label' => 'Get Grade9 Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_change-school-status',
            'label' => 'Change School Status',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-national-result-data',
            'label' => 'Get National Result Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_national-result-data',
            'label' => 'Manage National Result Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-school-salsa-value',
            'label' => 'Get School Salsa Values',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_school-salsa-value',
            'label' => 'Manage School Salsa Values',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-qualify-upper-sec-data',
            'label' => 'Get Qualify Upper Sec Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_qualify-upper-sec-data',
            'label' => 'Manage Qualify Upper Sec Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-school-pupil-teacher-stat',
            'label' => 'Get School Pupil Teacher Stat',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_school-pupil-teacher-stat',
            'label' => 'Manage School Pupil Teacher Stat',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-community-salsa-value',
            'label' => 'Get Community Salsa Value',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_community-salsa-value',
            'label' => 'Manage Community Salsa Value',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-subject',
            'label' => 'Get Subject Value',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_subject',
            'label' => 'Manage Subject',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_import_edit-file',
            'label' => 'Manage File(s)',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_import_update-file',
            'label' => 'Manage File(s)',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_dashboard',
            'label' => 'Check Dashboard',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_colorcode',
            'label' => 'Manage Color Codes',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-colorcode',
            'label' => 'Manage Color Codes',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_triangles',
            'label' => 'Manage Triangles',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-triangles',
            'label' => 'Manage Triangles',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-client',
            'label' => 'Get Clients Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_client',
            'label' => 'Manage Clients',
        ]);
        //////////////////////////// Import Data Module //////////////////
        Permission::firstOrCreate([
            'title' => 'manage_import_download',
            'label' => 'Download Recent Data Files',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_communities',
            'label' => 'Import Communities',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_schools',
            'label' => 'Import Schools',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_pupil-stats',
            'label' => 'Import Teachers Pupil Stats',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_national-results',
            'label' => 'Import National Results',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_upper-sec-data',
            'label' => 'Import Upper Secondary Schools',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_grade9-data',
            'label' => 'Import Grade9 Data',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_import_school-salsa-values',
            'label' => 'Import Salsa Values',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_get-admin',
            'label' => 'Get Admin Data',
        ]);

        //////////////// General Settings Module /////////////
        Permission::firstOrCreate([
            'title' => 'manage_admin_setting',
            'label' => 'Manage General Settings',
        ]);
        Permission::firstOrCreate([
            'title' => 'manage_admin_get-setting',
            'label' => 'Manage General Settings',
        ]);
        Permission::firstOrCreate([
            'title' => 'manage_admin_change-setting-status',
            'label' => 'Manage General Settings',
        ]);

        Permission::firstOrCreate([
            'title' => 'manage_admin_edit-colorcode',
            'label' => 'Edit Color Codes',
        ]);
        
        Permission::firstOrCreate([
            'title' => 'manage_admin_children',
            'label' => 'Manage Children',
        ]);
        
        Permission::firstOrCreate([
            'title' => 'manage_admin_get-children',
            'label' => 'Get Children Data',
        ]);
        $role = Role::find(1);

        $role->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
            25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45]);

        $role = Role::find(2);

        $role->permissions()->sync([2, 3, 4, 5, 6, 7, 8, 9, 10, 11,
            12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
            26, 27, 28, 29, 30, 40, 41, 42, 43, 44, 45]);
    }
}
