<?php

use Illuminate\Database\Seeder;
use App\ColorCode;

class ColorCodeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //Free version
        /*ColorCode::firstOrCreate([
            'is_free' => '1',
            'label' => 'Salsa scale',
            'key' => 'Salsa scale',
            'created_by' => '1',
            'updated_by' => '1',
        ]);*/

        //Genomsnittligt meritvärde
        ColorCode::firstOrCreate([
            'is_free' => '1',
            'label' => 'Genomsnittligt meritvärde',
            'key' => 'Residual (R=F-B)',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'is_free' => '1',
            'label' => 'Genomsnittligt meritvärde',
            'key' => 'Faktiskt värde (F)',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'is_free' => '1',
            'label' => 'Genomsnittligt meritvärde',
            'key' => 'Modell-beräknat värde (B)',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        //End of free version

        //Paid version
        //Genomsnittligt meritvärde
        ColorCode::firstOrCreate([
            'label' => 'Genomsnittligt meritvärde',
            'key' => 'Residual (R=F-B)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Genomsnittligt meritvärde',
            'key' => 'Faktiskt värde (F)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Genomsnittligt meritvärde',
            'key' => 'Modell-beräknat värde (B)',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Bakgrundsinformation
        ColorCode::firstOrCreate([
            'label' => 'Bakgrundsinformation',
            'key' => 'Föräldrarnas genomsnittliga utb.nivå',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Bakgrundsinformation',
            'key' => 'Andel (%) nyinvandrade',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Bakgrundsinformation',
            'key' => 'Andel (%) pojkar',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Andel (%) som uppn. kunskapskraven
        ColorCode::firstOrCreate([
            'label' => 'Andel (%) som uppn. kunskapskraven',
            'key' => 'Residual (R=F-B)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Andel (%) som uppn. kunskapskraven',
            'key' => 'Faktiskt värde (F)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Andel (%) som uppn. kunskapskraven',
            'key' => 'Modellberäknat värde (B)',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Behörighet till gymnasieskolan inklusive okänd bakgrund
        ColorCode::firstOrCreate([
            'label' => 'Behörighet till gymnasieskolan inklusive okänd bakgrund',
            'key' => 'Naturvetenskapligt och tekniskt program',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Behörighet till gymnasieskolan inklusive okänd bakgrund',
            'key' => 'Ekonomi-, humanistiska och samhällsvetenskapsprogram',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Behörighet till gymnasieskolan inklusive okänd bakgrund',
            'key' => 'Estetiskt program',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Behörighet till gymnasieskolan inklusive okänd bakgrund',
            'key' => 'Yrkesprogram',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Subjects
        //Biology
        ColorCode::firstOrCreate([
            'label' => 'Biologi',
            'subject_id' => '1',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Biologi',
            'subject_id' => '1',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Biologi',
            'subject_id' => '1',
            'key' => 'NP-resultat (national results merit point)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Biologi',
            'subject_id' => '1',
            'key' => 'Andel som deltagit (share participated in national results)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Biologi',
            'subject_id' => '1',
            'key' => 'Antal som deltagit (number of students participated, not shown)',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //English
        ColorCode::firstOrCreate([
            'label' => 'Engelska',
            'subject_id' => '2',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Engelska',
            'subject_id' => '2',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Engelska',
            'subject_id' => '2',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Engelska',
            'subject_id' => '2',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Engelska',
            'subject_id' => '2',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Fysik
        ColorCode::firstOrCreate([
            'label' => 'Fysik',
            'subject_id' => '3',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Fysik',
            'subject_id' => '3',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Fysik',
            'subject_id' => '3',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Fysik',
            'subject_id' => '3',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Fysik',
            'subject_id' => '3',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Geografy
        ColorCode::firstOrCreate([
            'label' => 'Geografi',
            'subject_id' => '4',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Geografi',
            'subject_id' => '4',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Geografi',
            'subject_id' => '4',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Geografi',
            'subject_id' => '4',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Geografi',
            'subject_id' => '4',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Kemi
        ColorCode::firstOrCreate([
            'label' => 'Kemi',
            'subject_id' => '5',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Kemi',
            'subject_id' => '5',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Kemi',
            'subject_id' => '5',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Kemi',
            'subject_id' => '5',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Kemi',
            'subject_id' => '5',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Matematik
        ColorCode::firstOrCreate([
            'label' => 'Matematik',
            'subject_id' => '6',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Matematik',
            'subject_id' => '6',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Matematik',
            'subject_id' => '6',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Matematik',
            'subject_id' => '6',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Matematik',
            'subject_id' => '6',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Religionskunskap
        ColorCode::firstOrCreate([
            'label' => 'Religionskunskap',
            'subject_id' => '7',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Religionskunskap',
            'subject_id' => '7',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Religionskunskap',
            'subject_id' => '7',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Religionskunskap',
            'subject_id' => '7',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Religionskunskap',
            'subject_id' => '7',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Samhällskunskap
        ColorCode::firstOrCreate([
            'label' => 'Samhällskunskap',
            'subject_id' => '8',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Samhällskunskap',
            'subject_id' => '8',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Samhällskunskap',
            'subject_id' => '8',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Samhällskunskap',
            'subject_id' => '8',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Samhällskunskap',
            'subject_id' => '8',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Svenska
        ColorCode::firstOrCreate([
            'label' => 'Svenska',
            'subject_id' => '9',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Svenska',
            'subject_id' => '9',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Svenska',
            'subject_id' => '9',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Svenska',
            'subject_id' => '9',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Svenska',
            'subject_id' => '9',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Historia
        ColorCode::firstOrCreate([
            'label' => 'Historia',
            'subject_id' => '10',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Historia',
            'subject_id' => '10',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Historia',
            'subject_id' => '10',
            'key' => 'NP-resultat',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Historia',
            'subject_id' => '10',
            'key' => 'Andel som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        /*ColorCode::firstOrCreate([
            'label' => 'Historia',
            'subject_id' => '10',
            'key' => 'Antal som deltagit',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/

        //Svenska som andraspråk
        ColorCode::firstOrCreate([
            'label' => 'Svenska som andraspråk',
            'subject_id' => '11',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Svenska som andraspråk',
            'subject_id' => '11',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Bild
        ColorCode::firstOrCreate([
            'label' => 'Bild',
            'subject_id' => '12',
            'key' => 'Betygspoäng (Merit rating)',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Bild',
            'subject_id' => '12',
            'key' => 'Andel (%) med A-E (Share A-E)',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Hem och konsumentkunskap
        ColorCode::firstOrCreate([
            'label' => 'Hem och konsumentkunskap',
            'subject_id' => '13',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Hem och konsumentkunskap',
            'subject_id' => '13',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Idrott och hälsa
        ColorCode::firstOrCreate([
            'label' => 'Idrott och hälsa',
            'subject_id' => '14',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Idrott och hälsa',
            'subject_id' => '14',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Moderna språk, elevens val
        ColorCode::firstOrCreate([
            'label' => 'Moderna språk, elevens val',
            'subject_id' => '15',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Moderna språk, elevens val',
            'subject_id' => '15',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Moderna språk, språkval
        ColorCode::firstOrCreate([
            'label' => 'Moderna språk, språkval',
            'subject_id' => '16',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Moderna språk, språkval',
            'subject_id' => '16',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Modersmål
        ColorCode::firstOrCreate([
            'label' => 'Modersmål',
            'subject_id' => '17',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Modersmål',
            'subject_id' => '17',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Musik
        ColorCode::firstOrCreate([
            'label' => 'Musik',
            'subject_id' => '18',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Musik',
            'subject_id' => '18',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Slöjd
        ColorCode::firstOrCreate([
            'label' => 'Slöjd',
            'subject_id' => '19',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Slöjd',
            'subject_id' => '19',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Teknik
        ColorCode::firstOrCreate([
            'label' => 'Teknik',
            'subject_id' => '20',
            'key' => 'Betygspoäng',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Teknik',
            'subject_id' => '20',
            'key' => 'Andel (%) med A-E',
            'created_by' => '1', 'updated_by' => '1',
        ]);

        //Personal
        /*ColorCode::firstOrCreate([
            'label' => 'Personal',
            'key' => 'Antal lärare',
            'created_by' => '1', 'updated_by' => '1',
        ]);*/
        ColorCode::firstOrCreate([
            'label' => 'Personal',
            'key' => 'Elever per lärare',
            'created_by' => '1', 'updated_by' => '1',
        ]);
        ColorCode::firstOrCreate([
            'label' => 'Personal',
            'key' => 'Andel med pedagogisk högskoleexamen',
            'created_by' => '1', 'updated_by' => '1',
        ]);
    }
}
