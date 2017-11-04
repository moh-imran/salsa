<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(SubjectsSeeder::class);
        $this->call(ColorCodeSeed::class);
        $this->call(CommunitiesTableSeeder::class);
        $this->call(SubcummunitySchoolsTableSeeder::class);
        $this->call(CommunitySalsaValuesTableSeeder::class);
        $this->call(ExcelImportMetasTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(TrianglesTableSeeder::class);
    }
}
