<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('language')->delete();
        
        \DB::table('language')->insert(array (
            0 => 
            array (
                'id' => 1,
                'language' => 'Hindi',
            ),
            1 => 
            array (
                'id' => 2,
                'language' => 'Bengali',
            ),
            2 => 
            array (
                'id' => 3,
                'language' => 'Telugu',
            ),
            3 => 
            array (
                'id' => 4,
                'language' => 'Marathi',
            ),
            4 => 
            array (
                'id' => 5,
                'language' => 'Tamil',
            ),
            5 => 
            array (
                'id' => 6,
                'language' => 'Urdu',
            ),
            6 => 
            array (
                'id' => 7,
                'language' => 'Gujarati',
            ),
            7 => 
            array (
                'id' => 8,
                'language' => 'Kannada',
            ),
            8 => 
            array (
                'id' => 9,
                'language' => 'Malayalam',
            ),
            9 => 
            array (
                'id' => 10,
                'language' => 'Odia',
            ),
            10 => 
            array (
                'id' => 11,
                'language' => 'Punjabi',
            ),
            11 => 
            array (
                'id' => 12,
                'language' => 'Assamese',
            ),
            12 => 
            array (
                'id' => 13,
                'language' => 'Maithili',
            ),
            13 => 
            array (
                'id' => 14,
                'language' => 'Bhili/Bhilodi',
            ),
            14 => 
            array (
                'id' => 15,
                'language' => 'Santali',
            ),
            15 => 
            array (
                'id' => 16,
                'language' => 'Kashmiri',
            ),
            16 => 
            array (
                'id' => 17,
                'language' => 'Nepali',
            ),
            17 => 
            array (
                'id' => 18,
                'language' => 'Gondi',
            ),
            18 => 
            array (
                'id' => 19,
                'language' => 'Sindhi',
            ),
            19 => 
            array (
                'id' => 20,
                'language' => 'Konkani',
            ),
            20 => 
            array (
                'id' => 21,
                'language' => 'Dogri',
            ),
            21 => 
            array (
                'id' => 22,
                'language' => 'Khandeshi',
            ),
            22 => 
            array (
                'id' => 23,
                'language' => 'Kurukh',
            ),
            23 => 
            array (
                'id' => 24,
                'language' => 'Tulu',
            ),
            24 => 
            array (
                'id' => 25,
                'language' => 'Meitei/Manipuri',
            ),
            25 => 
            array (
                'id' => 26,
                'language' => 'Bodo',
            ),
            26 => 
            array (
                'id' => 27,
                'language' => 'Khasi',
            ),
            27 => 
            array (
                'id' => 28,
                'language' => 'Mundari',
            ),
            28 => 
            array (
                'id' => 29,
                'language' => 'Ho',
            ),
            29 => 
            array (
                'id' => 30,
                'language' => 'Kui',
            ),
            30 => 
            array (
                'id' => 31,
                'language' => 'Garo',
            ),
            31 => 
            array (
                'id' => 32,
                'language' => 'Tripuri',
            ),
            32 => 
            array (
                'id' => 33,
                'language' => 'Lushai/Mizo',
            ),
            33 => 
            array (
                'id' => 34,
                'language' => 'Halabi',
            ),
            34 => 
            array (
                'id' => 35,
                'language' => 'Korku',
            ),
            35 => 
            array (
                'id' => 36,
                'language' => 'Miri/Mishing',
            ),
            36 => 
            array (
                'id' => 37,
                'language' => 'Munda',
            ),
            37 => 
            array (
                'id' => 38,
                'language' => 'Karbi/Mikir',
            ),
            38 => 
            array (
                'id' => 39,
                'language' => 'Koya',
            ),
            39 => 
            array (
                'id' => 40,
                'language' => 'Ao',
            ),
            40 => 
            array (
                'id' => 41,
                'language' => 'Savara',
            ),
            41 => 
            array (
                'id' => 42,
                'language' => 'Konyak',
            ),
            42 => 
            array (
                'id' => 43,
                'language' => 'Kharia',
            ),
            43 => 
            array (
                'id' => 44,
                'language' => 'English',
            ),
            44 => 
            array (
                'id' => 45,
                'language' => 'Malto',
            ),
            45 => 
            array (
                'id' => 46,
                'language' => 'Nissi/Dafla',
            ),
            46 => 
            array (
                'id' => 47,
                'language' => 'Adi',
            ),
            47 => 
            array (
                'id' => 48,
                'language' => 'Thado',
            ),
            48 => 
            array (
                'id' => 49,
                'language' => 'Lotha',
            ),
            49 => 
            array (
                'id' => 50,
                'language' => 'Coorgi/Kodagu',
            ),
            50 => 
            array (
                'id' => 51,
                'language' => 'Rabha',
            ),
            51 => 
            array (
                'id' => 52,
                'language' => 'Tangkhul',
            ),
            52 => 
            array (
                'id' => 53,
                'language' => 'Kisan',
            ),
            53 => 
            array (
                'id' => 54,
                'language' => 'Angami',
            ),
            54 => 
            array (
                'id' => 55,
                'language' => 'Phom',
            ),
            55 => 
            array (
                'id' => 56,
                'language' => 'Kolami',
            ),
            56 => 
            array (
                'id' => 57,
                'language' => 'Khond/Kondh',
            ),
            57 => 
            array (
                'id' => 58,
                'language' => 'Dimasa',
            ),
            58 => 
            array (
                'id' => 59,
                'language' => 'Ladakhi',
            ),
            59 => 
            array (
                'id' => 60,
                'language' => 'Sema',
            ),
        ));
        
        
    }
}