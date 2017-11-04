<?php

use Illuminate\Database\Seeder;

class ExcelImportMetasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('excel_import_metas')->delete();
        
        \DB::table('excel_import_metas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title_key' => 'Schools Data',
                'key' => 'Schools Data',
                'download_url' => 'http://www.skolverket.se/polopoly_fs/1.215072!/Skolenhetsregistret.xls',
                'relative_path_on_server' => '../storage/app/files/schools/Skolenhetsregistret_2016_2016_12_19_15_44_26.xls',
                'from_year' => 2016,
                'to_year' => 2016,
                'description' => 'Schools Data import file',
                'first_data_row' => 2,
                'file_size' => 5706,
                'checksum_of_last_file' => 'dfa9a2c2bff6465270cc02ebe0e5db3d',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:44:41',
                'updated_at' => '2016-12-19 16:05:56',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title_key' => 'Salsa Schools Data',
                'key' => 'Salsa Schools Data',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=95&psVerksamhetsar=2015&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/salsa/exp_salsa_2015_2016_12_19_15_44_41.xlsx',
                'from_year' => 2015,
                'to_year' => 2015,
                'description' => 'Salsa Schools Data import file',
                'first_data_row' => 8,
                'file_size' => 116,
                'checksum_of_last_file' => '4bd823ea3081eb0362e7bc00dac9a7db',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:44:44',
                'updated_at' => '2016-12-20 05:46:14',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title_key' => 'Salsa Schools Data',
                'key' => 'Salsa Schools Data',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=95&psVerksamhetsar=2014&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/salsa/exp_salsa_2014_2016_12_19_15_44_44.xlsx',
                'from_year' => 2014,
                'to_year' => 2014,
                'description' => 'Salsa Schools Data import file',
                'first_data_row' => 8,
                'file_size' => 117,
                'checksum_of_last_file' => 'a4eb6933b16d2012681d584ead874128',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:44:47',
                'updated_at' => '2016-12-20 05:46:14',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title_key' => 'Salsa Schools Data',
                'key' => 'Salsa Schools Data',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=95&psVerksamhetsar=2013&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/salsa/exp_salsa_2013_2016_12_19_15_44_47.xlsx',
                'from_year' => 2013,
                'to_year' => 2013,
                'description' => 'Salsa Schools Data import file',
                'first_data_row' => 8,
                'file_size' => 115,
                'checksum_of_last_file' => '8e911dd94f694c2bdf336945cc72939d',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:44:49',
                'updated_at' => '2016-12-20 05:46:14',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title_key' => 'Qualified Upper Secondary Schools Data',
                'key' => 'Qualified Upper Secondary Schools Data',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=5&psVerksamhetsar=2016&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/qualified/exp_behorig_gy_2016_2016_12_19_15_44_49.xlsx',
                'from_year' => 2016,
                'to_year' => 2016,
                'description' => 'Qualified Upper Secondary Schools Data import file',
                'first_data_row' => 9,
                'file_size' => 322,
                'checksum_of_last_file' => '060bd9e74ca126925ef5a8ac74dca11c',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:44:53',
                'updated_at' => '2016-12-19 16:43:31',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'title_key' => 'Grades Per Subject Data',
                'key' => 'Grades Per Subject Data',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=93&psVerksamhetsar=2016&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/grades/exp_slutbetyg_amne_skola_2016_2016_12_19_15_44_53.xlsx',
                'from_year' => 2016,
                'to_year' => 2016,
                'description' => 'Grades Per Subject Data import file',
                'first_data_row' => 11,
                'file_size' => 1750,
                'checksum_of_last_file' => 'ed8ab22d8d7e3790e20683e51f1d7de7',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:45:09',
                'updated_at' => '2016-12-20 05:27:27',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'title_key' => 'National Test Results Data',
                'key' => 'exp_ap9_no_',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=75&psVerksamhetsar=2016&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/national/exp_ap9_no_2013_2016_2016_12_19_15_45_09.xlsx',
                'from_year' => 2016,
                'to_year' => 2016,
                'description' => 'National Test Results Data import file',
                'first_data_row' => 9,
                'file_size' => 171,
                'checksum_of_last_file' => 'ae3fe8216c894f1fbcf18d96014ecac1',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:45:13',
                'updated_at' => '2016-12-19 15:45:13',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'title_key' => 'National Test Results Data',
                'key' => 'exp_ap9_so_',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=76&psVerksamhetsar=2016&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/national/exp_ap9_so_2013_2016_2016_12_19_15_45_13.xlsx',
                'from_year' => 2016,
                'to_year' => 2016,
                'description' => 'National Test Results Data import file',
                'first_data_row' => 9,
                'file_size' => 184,
                'checksum_of_last_file' => 'ae98d5d972725d024d182eddc4c513c3',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:45:16',
                'updated_at' => '2016-12-19 15:45:16',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'title_key' => 'National Test Results Data',
                'key' => 'exp_ap9_masven_gr_',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=77&psVerksamhetsar=2016&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/national/exp_ap9_masven_gr_2013_2016_2016_12_19_15_45_16.xlsx',
                'from_year' => 2016,
                'to_year' => 2016,
                'description' => 'National Test Results Data import file',
                'first_data_row' => 9,
                'file_size' => 361,
                'checksum_of_last_file' => 'b600af0397576a8858103f4b10c493aa',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:45:29',
                'updated_at' => '2016-12-19 15:45:29',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'title_key' => 'Teachers Data',
                'key' => 'exp_personal_gr_',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=16&psVerksamhetsar=2015&psOmgang=&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/teachers/exp_personal_gr_2015_2016_12_19_15_45_29.xlsx',
                'from_year' => 2015,
                'to_year' => 2015,
                'description' => 'Teachers Data import file',
                'first_data_row' => 7,
                'file_size' => 378,
                'checksum_of_last_file' => '7090fbdb1f0637c565377c3f21016d10',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:45:50',
                'updated_at' => '2016-12-19 16:05:56',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'title_key' => 'Teachers Data',
                'key' => 'exp_pers_amne_gr_skola_',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=101&psVerksamhetsar=2015&psOmgang=1&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/teachers/exp_pers_amne_gr_skola_2015_2016_12_19_15_45_50.xlsx',
                'from_year' => 2015,
                'to_year' => 2015,
                'description' => 'Teachers Data import file',
                'first_data_row' => 9,
                'file_size' => 319,
                'checksum_of_last_file' => 'e7e9e5089c1ac22dfa30291d4b173b00',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:45:55',
                'updated_at' => '2016-12-19 16:05:56',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'title_key' => 'Teachers Data',
                'key' => 'exp_pers_amne_gr_skola_amne_',
                'download_url' => 'http://siris.skolverket.se/siris/ris.export_stat.export?pnExportID=102&psVerksamhetsar=2015&psOmgang=1&psFormat=EXCEL&psLanKod=&psKommunKod=&psHmanKod=&psToken=',
                'relative_path_on_server' => '../storage/app/files/teachers/exp_pers_amne_gr_skola_amne_2015_2016_12_19_15_45_55.xlsx',
                'from_year' => 2015,
                'to_year' => 2015,
                'description' => 'Teachers Data import file',
                'first_data_row' => 10,
                'file_size' => 3734,
                'checksum_of_last_file' => 'e45619162ce2d0d98d8715a9400e68c3',
                'version_no' => 1,
                'status' => 1,
                'created_at' => '2016-12-19 15:46:51',
                'updated_at' => '2016-12-19 15:46:51',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}