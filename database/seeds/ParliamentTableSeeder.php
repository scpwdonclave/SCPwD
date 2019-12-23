<?php

use Illuminate\Database\Seeder;

class ParliamentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('parliament')->delete();
        
        \DB::table('parliament')->insert(array (
            0 => 
            array (
                'id' => 1,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Araku',
            ),
            1 => 
            array (
                'id' => 2,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Srikakulam',
            ),
            2 => 
            array (
                'id' => 3,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Vizianagaram',
            ),
            3 => 
            array (
                'id' => 4,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Visakhapatnam',
            ),
            4 => 
            array (
                'id' => 5,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Anakapalli',
            ),
            5 => 
            array (
                'id' => 6,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Kakinada',
            ),
            6 => 
            array (
                'id' => 7,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Amalapuram',
            ),
            7 => 
            array (
                'id' => 8,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Rajahmundry',
            ),
            8 => 
            array (
                'id' => 9,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Narasapuram',
            ),
            9 => 
            array (
                'id' => 10,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Eluru',
            ),
            10 => 
            array (
                'id' => 11,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Machilipatnam',
            ),
            11 => 
            array (
                'id' => 12,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Vijayawada',
            ),
            12 => 
            array (
                'id' => 13,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Guntur',
            ),
            13 => 
            array (
                'id' => 14,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Narasaraopet',
            ),
            14 => 
            array (
                'id' => 15,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Bapatla',
            ),
            15 => 
            array (
                'id' => 16,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Ongole',
            ),
            16 => 
            array (
                'id' => 17,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Nandyal',
            ),
            17 => 
            array (
                'id' => 18,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Kurnool',
            ),
            18 => 
            array (
                'id' => 19,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Anantapur',
            ),
            19 => 
            array (
                'id' => 20,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Hindupur',
            ),
            20 => 
            array (
                'id' => 21,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Kadapa',
            ),
            21 => 
            array (
                'id' => 22,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Nellore',
            ),
            22 => 
            array (
                'id' => 23,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Tirupati',
            ),
            23 => 
            array (
                'id' => 24,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Rajampet',
            ),
            24 => 
            array (
                'id' => 25,
                'state_ut' => 'Andhra Pradesh',
                'constituency' => 'Chittoor',
            ),
            25 => 
            array (
                'id' => 26,
                'state_ut' => 'Arunachal Pradesh',
                'constituency' => 'Arunachal East',
            ),
            26 => 
            array (
                'id' => 27,
                'state_ut' => 'Arunachal Pradesh',
                'constituency' => 'Arunachal West',
            ),
            27 => 
            array (
                'id' => 28,
                'state_ut' => 'Assam',
                'constituency' => 'Karimganj',
            ),
            28 => 
            array (
                'id' => 29,
                'state_ut' => 'Assam',
                'constituency' => 'Silchar',
            ),
            29 => 
            array (
                'id' => 30,
                'state_ut' => 'Assam',
                'constituency' => 'Autonomous District',
            ),
            30 => 
            array (
                'id' => 31,
                'state_ut' => 'Assam',
                'constituency' => 'Dhubri',
            ),
            31 => 
            array (
                'id' => 32,
                'state_ut' => 'Assam',
                'constituency' => 'Kokrajhar',
            ),
            32 => 
            array (
                'id' => 33,
                'state_ut' => 'Assam',
                'constituency' => 'Barpeta',
            ),
            33 => 
            array (
                'id' => 34,
                'state_ut' => 'Assam',
                'constituency' => 'Gauhati',
            ),
            34 => 
            array (
                'id' => 35,
                'state_ut' => 'Assam',
                'constituency' => 'Mangaldoi',
            ),
            35 => 
            array (
                'id' => 36,
                'state_ut' => 'Assam',
                'constituency' => 'Tezpur',
            ),
            36 => 
            array (
                'id' => 37,
                'state_ut' => 'Assam',
                'constituency' => 'Nowgong',
            ),
            37 => 
            array (
                'id' => 38,
                'state_ut' => 'Assam',
                'constituency' => 'Kaliabor',
            ),
            38 => 
            array (
                'id' => 39,
                'state_ut' => 'Assam',
                'constituency' => 'Jorhat',
            ),
            39 => 
            array (
                'id' => 40,
                'state_ut' => 'Assam',
                'constituency' => 'Dibrugarh',
            ),
            40 => 
            array (
                'id' => 41,
                'state_ut' => 'Assam',
                'constituency' => 'Lakhimpur',
            ),
            41 => 
            array (
                'id' => 42,
                'state_ut' => 'Bihar',
                'constituency' => 'Valmiki Nagar',
            ),
            42 => 
            array (
                'id' => 43,
                'state_ut' => 'Bihar',
                'constituency' => 'Paschim Champaran',
            ),
            43 => 
            array (
                'id' => 44,
                'state_ut' => 'Bihar',
                'constituency' => 'Purvi Champaran',
            ),
            44 => 
            array (
                'id' => 45,
                'state_ut' => 'Bihar',
                'constituency' => 'Sheohar',
            ),
            45 => 
            array (
                'id' => 46,
                'state_ut' => 'Bihar',
                'constituency' => 'Sitamarhi',
            ),
            46 => 
            array (
                'id' => 47,
                'state_ut' => 'Bihar',
                'constituency' => 'Madhubani',
            ),
            47 => 
            array (
                'id' => 48,
                'state_ut' => 'Bihar',
                'constituency' => 'Jhanjharpur',
            ),
            48 => 
            array (
                'id' => 49,
                'state_ut' => 'Bihar',
                'constituency' => 'Supaul',
            ),
            49 => 
            array (
                'id' => 50,
                'state_ut' => 'Bihar',
                'constituency' => 'Araria',
            ),
            50 => 
            array (
                'id' => 51,
                'state_ut' => 'Bihar',
                'constituency' => 'Kishanganj',
            ),
            51 => 
            array (
                'id' => 52,
                'state_ut' => 'Bihar',
                'constituency' => 'Katihar',
            ),
            52 => 
            array (
                'id' => 53,
                'state_ut' => 'Bihar',
                'constituency' => 'Purnia',
            ),
            53 => 
            array (
                'id' => 54,
                'state_ut' => 'Bihar',
                'constituency' => 'Madhepura',
            ),
            54 => 
            array (
                'id' => 55,
                'state_ut' => 'Bihar',
                'constituency' => 'Darbhanga',
            ),
            55 => 
            array (
                'id' => 56,
                'state_ut' => 'Bihar',
                'constituency' => 'Muzaffarpur',
            ),
            56 => 
            array (
                'id' => 57,
                'state_ut' => 'Bihar',
                'constituency' => 'Vaishali',
            ),
            57 => 
            array (
                'id' => 58,
                'state_ut' => 'Bihar',
                'constituency' => 'Gopalganj',
            ),
            58 => 
            array (
                'id' => 59,
                'state_ut' => 'Bihar',
                'constituency' => 'Siwan',
            ),
            59 => 
            array (
                'id' => 60,
                'state_ut' => 'Bihar',
                'constituency' => 'Maharajganj',
            ),
            60 => 
            array (
                'id' => 61,
                'state_ut' => 'Bihar',
                'constituency' => 'Saran',
            ),
            61 => 
            array (
                'id' => 62,
                'state_ut' => 'Bihar',
                'constituency' => 'Hajipur',
            ),
            62 => 
            array (
                'id' => 63,
                'state_ut' => 'Bihar',
                'constituency' => 'Ujiarpur',
            ),
            63 => 
            array (
                'id' => 64,
                'state_ut' => 'Bihar',
                'constituency' => 'Samastipur',
            ),
            64 => 
            array (
                'id' => 65,
                'state_ut' => 'Bihar',
                'constituency' => 'Begusarai',
            ),
            65 => 
            array (
                'id' => 66,
                'state_ut' => 'Bihar',
                'constituency' => 'Khagaria',
            ),
            66 => 
            array (
                'id' => 67,
                'state_ut' => 'Bihar',
                'constituency' => 'Bhagalpur',
            ),
            67 => 
            array (
                'id' => 68,
                'state_ut' => 'Bihar',
                'constituency' => 'Banka',
            ),
            68 => 
            array (
                'id' => 69,
                'state_ut' => 'Bihar',
                'constituency' => 'Munger',
            ),
            69 => 
            array (
                'id' => 70,
                'state_ut' => 'Bihar',
                'constituency' => 'Nalanda',
            ),
            70 => 
            array (
                'id' => 71,
                'state_ut' => 'Bihar',
                'constituency' => 'Patna Sahib',
            ),
            71 => 
            array (
                'id' => 72,
                'state_ut' => 'Bihar',
                'constituency' => 'Pataliputra',
            ),
            72 => 
            array (
                'id' => 73,
                'state_ut' => 'Bihar',
                'constituency' => 'Arrah',
            ),
            73 => 
            array (
                'id' => 74,
                'state_ut' => 'Bihar',
                'constituency' => 'Buxar',
            ),
            74 => 
            array (
                'id' => 75,
                'state_ut' => 'Bihar',
                'constituency' => 'Sasaram',
            ),
            75 => 
            array (
                'id' => 76,
                'state_ut' => 'Bihar',
                'constituency' => 'Karakat',
            ),
            76 => 
            array (
                'id' => 77,
                'state_ut' => 'Bihar',
                'constituency' => 'Jahanabad',
            ),
            77 => 
            array (
                'id' => 78,
                'state_ut' => 'Bihar',
                'constituency' => 'Aurangabad',
            ),
            78 => 
            array (
                'id' => 79,
                'state_ut' => 'Bihar',
                'constituency' => 'Gaya',
            ),
            79 => 
            array (
                'id' => 80,
                'state_ut' => 'Bihar',
                'constituency' => 'Nawada',
            ),
            80 => 
            array (
                'id' => 81,
                'state_ut' => 'Bihar',
                'constituency' => 'Jamui',
            ),
            81 => 
            array (
                'id' => 82,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Sarguja',
            ),
            82 => 
            array (
                'id' => 83,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Raigarh',
            ),
            83 => 
            array (
                'id' => 84,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Janjgir',
            ),
            84 => 
            array (
                'id' => 85,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Korba',
            ),
            85 => 
            array (
                'id' => 86,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Bilaspur',
            ),
            86 => 
            array (
                'id' => 87,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Rajnandgaon',
            ),
            87 => 
            array (
                'id' => 88,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Durg',
            ),
            88 => 
            array (
                'id' => 89,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Raipur',
            ),
            89 => 
            array (
                'id' => 90,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Mahasamund',
            ),
            90 => 
            array (
                'id' => 91,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Bastar',
            ),
            91 => 
            array (
                'id' => 92,
                'state_ut' => 'Chattisgarh',
                'constituency' => 'Kanker',
            ),
            92 => 
            array (
                'id' => 93,
                'state_ut' => 'Goa',
                'constituency' => 'North Goa',
            ),
            93 => 
            array (
                'id' => 94,
                'state_ut' => 'Goa',
                'constituency' => 'South Goa',
            ),
            94 => 
            array (
                'id' => 95,
                'state_ut' => 'Gujarat',
                'constituency' => 'Kutch',
            ),
            95 => 
            array (
                'id' => 96,
                'state_ut' => 'Gujarat',
                'constituency' => 'Banaskantha',
            ),
            96 => 
            array (
                'id' => 97,
                'state_ut' => 'Gujarat',
                'constituency' => 'Patan',
            ),
            97 => 
            array (
                'id' => 98,
                'state_ut' => 'Gujarat',
                'constituency' => 'Mahesana',
            ),
            98 => 
            array (
                'id' => 99,
                'state_ut' => 'Gujarat',
                'constituency' => 'Sabarkantha',
            ),
            99 => 
            array (
                'id' => 100,
                'state_ut' => 'Gujarat',
                'constituency' => 'Gandhinagar',
            ),
            100 => 
            array (
                'id' => 101,
                'state_ut' => 'Gujarat',
                'constituency' => 'Ahmedabad East',
            ),
            101 => 
            array (
                'id' => 102,
                'state_ut' => 'Gujarat',
                'constituency' => 'Ahmedabad West',
            ),
            102 => 
            array (
                'id' => 103,
                'state_ut' => 'Gujarat',
                'constituency' => 'Surendranagar',
            ),
            103 => 
            array (
                'id' => 104,
                'state_ut' => 'Gujarat',
                'constituency' => 'Rajkot',
            ),
            104 => 
            array (
                'id' => 105,
                'state_ut' => 'Gujarat',
                'constituency' => 'Porbandar',
            ),
            105 => 
            array (
                'id' => 106,
                'state_ut' => 'Gujarat',
                'constituency' => 'Jamnagar',
            ),
            106 => 
            array (
                'id' => 107,
                'state_ut' => 'Gujarat',
                'constituency' => 'Junagadh',
            ),
            107 => 
            array (
                'id' => 108,
                'state_ut' => 'Gujarat',
                'constituency' => 'Amreli',
            ),
            108 => 
            array (
                'id' => 109,
                'state_ut' => 'Gujarat',
                'constituency' => 'Bhavnagar',
            ),
            109 => 
            array (
                'id' => 110,
                'state_ut' => 'Gujarat',
                'constituency' => 'Anand',
            ),
            110 => 
            array (
                'id' => 111,
                'state_ut' => 'Gujarat',
                'constituency' => 'Kheda',
            ),
            111 => 
            array (
                'id' => 112,
                'state_ut' => 'Gujarat',
                'constituency' => 'Panchmahal',
            ),
            112 => 
            array (
                'id' => 113,
                'state_ut' => 'Gujarat',
                'constituency' => 'Dahod',
            ),
            113 => 
            array (
                'id' => 114,
                'state_ut' => 'Gujarat',
                'constituency' => 'Vadodara',
            ),
            114 => 
            array (
                'id' => 115,
                'state_ut' => 'Gujarat',
                'constituency' => 'Chhota Udaipur',
            ),
            115 => 
            array (
                'id' => 116,
                'state_ut' => 'Gujarat',
                'constituency' => 'Bharuch',
            ),
            116 => 
            array (
                'id' => 117,
                'state_ut' => 'Gujarat',
                'constituency' => 'Bardoli',
            ),
            117 => 
            array (
                'id' => 118,
                'state_ut' => 'Gujarat',
                'constituency' => 'Surat',
            ),
            118 => 
            array (
                'id' => 119,
                'state_ut' => 'Gujarat',
                'constituency' => 'Navsari',
            ),
            119 => 
            array (
                'id' => 120,
                'state_ut' => 'Gujarat',
                'constituency' => 'Valsad',
            ),
            120 => 
            array (
                'id' => 121,
                'state_ut' => 'Harayana',
                'constituency' => 'Ambala',
            ),
            121 => 
            array (
                'id' => 122,
                'state_ut' => 'Harayana',
                'constituency' => 'Kurukshetra',
            ),
            122 => 
            array (
                'id' => 123,
                'state_ut' => 'Harayana',
                'constituency' => 'Sirsa',
            ),
            123 => 
            array (
                'id' => 124,
                'state_ut' => 'Harayana',
                'constituency' => 'Hissar',
            ),
            124 => 
            array (
                'id' => 125,
                'state_ut' => 'Harayana',
                'constituency' => 'Karnal',
            ),
            125 => 
            array (
                'id' => 126,
                'state_ut' => 'Harayana',
                'constituency' => 'Sonipat',
            ),
            126 => 
            array (
                'id' => 127,
                'state_ut' => 'Harayana',
                'constituency' => 'Rohtak',
            ),
            127 => 
            array (
                'id' => 128,
                'state_ut' => 'Harayana',
                'constituency' => 'Bhiwani?Mahendragarh',
            ),
            128 => 
            array (
                'id' => 129,
                'state_ut' => 'Harayana',
                'constituency' => 'Gurgaon',
            ),
            129 => 
            array (
                'id' => 130,
                'state_ut' => 'Harayana',
                'constituency' => 'Faridabad',
            ),
            130 => 
            array (
                'id' => 131,
                'state_ut' => 'Himachal Pradesh',
                'constituency' => 'Kangra',
            ),
            131 => 
            array (
                'id' => 132,
                'state_ut' => 'Himachal Pradesh',
                'constituency' => 'Mandi',
            ),
            132 => 
            array (
                'id' => 133,
                'state_ut' => 'Himachal Pradesh',
                'constituency' => 'Hamirpur',
            ),
            133 => 
            array (
                'id' => 134,
                'state_ut' => 'Himachal Pradesh',
                'constituency' => 'Shimla',
            ),
            134 => 
            array (
                'id' => 135,
                'state_ut' => 'Jammu & Kashmir',
                'constituency' => 'Baramulla',
            ),
            135 => 
            array (
                'id' => 136,
                'state_ut' => 'Jammu & Kashmir',
                'constituency' => 'Srinagar',
            ),
            136 => 
            array (
                'id' => 137,
                'state_ut' => 'Jammu & Kashmir',
                'constituency' => 'Anantnag',
            ),
            137 => 
            array (
                'id' => 138,
                'state_ut' => 'Jammu & Kashmir',
                'constituency' => 'Udhampur',
            ),
            138 => 
            array (
                'id' => 139,
                'state_ut' => 'Jammu & Kashmir',
                'constituency' => 'Jammu',
            ),
            139 => 
            array (
                'id' => 140,
                'state_ut' => 'Ladakh',
                'constituency' => 'Ladakh',
            ),
            140 => 
            array (
                'id' => 141,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Rajmahal',
            ),
            141 => 
            array (
                'id' => 142,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Dumka',
            ),
            142 => 
            array (
                'id' => 143,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Godda',
            ),
            143 => 
            array (
                'id' => 144,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Chatra',
            ),
            144 => 
            array (
                'id' => 145,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Kodarma',
            ),
            145 => 
            array (
                'id' => 146,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Giridih',
            ),
            146 => 
            array (
                'id' => 147,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Dhanbad',
            ),
            147 => 
            array (
                'id' => 148,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Ranchi',
            ),
            148 => 
            array (
                'id' => 149,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Jamshedpur',
            ),
            149 => 
            array (
                'id' => 150,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Singhbhum',
            ),
            150 => 
            array (
                'id' => 151,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Khunti',
            ),
            151 => 
            array (
                'id' => 152,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Lohardaga',
            ),
            152 => 
            array (
                'id' => 153,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Palamau',
            ),
            153 => 
            array (
                'id' => 154,
                'state_ut' => 'Jharkhand',
                'constituency' => 'Hazaribagh',
            ),
            154 => 
            array (
                'id' => 155,
                'state_ut' => 'Karnataka',
                'constituency' => 'Chikkodi',
            ),
            155 => 
            array (
                'id' => 156,
                'state_ut' => 'Karnataka',
                'constituency' => 'Belagavi',
            ),
            156 => 
            array (
                'id' => 157,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bagalkot',
            ),
            157 => 
            array (
                'id' => 158,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bijapur',
            ),
            158 => 
            array (
                'id' => 159,
                'state_ut' => 'Karnataka',
                'constituency' => 'Gulbarga',
            ),
            159 => 
            array (
                'id' => 160,
                'state_ut' => 'Karnataka',
                'constituency' => 'Raichur',
            ),
            160 => 
            array (
                'id' => 161,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bidar',
            ),
            161 => 
            array (
                'id' => 162,
                'state_ut' => 'Karnataka',
                'constituency' => 'Koppal',
            ),
            162 => 
            array (
                'id' => 163,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bellary',
            ),
            163 => 
            array (
                'id' => 164,
                'state_ut' => 'Karnataka',
                'constituency' => 'Haveri',
            ),
            164 => 
            array (
                'id' => 165,
                'state_ut' => 'Karnataka',
                'constituency' => 'Dharwad',
            ),
            165 => 
            array (
                'id' => 166,
                'state_ut' => 'Karnataka',
                'constituency' => 'Uttara Kannada',
            ),
            166 => 
            array (
                'id' => 167,
                'state_ut' => 'Karnataka',
                'constituency' => 'Davanagere',
            ),
            167 => 
            array (
                'id' => 168,
                'state_ut' => 'Karnataka',
                'constituency' => 'Shimoga',
            ),
            168 => 
            array (
                'id' => 169,
                'state_ut' => 'Karnataka',
                'constituency' => 'Udupi Chikmagalur',
            ),
            169 => 
            array (
                'id' => 170,
                'state_ut' => 'Karnataka',
                'constituency' => 'Hassan',
            ),
            170 => 
            array (
                'id' => 171,
                'state_ut' => 'Karnataka',
                'constituency' => 'Dakshina Kannada',
            ),
            171 => 
            array (
                'id' => 172,
                'state_ut' => 'Karnataka',
                'constituency' => 'Chitradurga',
            ),
            172 => 
            array (
                'id' => 173,
                'state_ut' => 'Karnataka',
                'constituency' => 'Tumkur',
            ),
            173 => 
            array (
                'id' => 174,
                'state_ut' => 'Karnataka',
                'constituency' => 'Mandya',
            ),
            174 => 
            array (
                'id' => 175,
                'state_ut' => 'Karnataka',
                'constituency' => 'Mysore',
            ),
            175 => 
            array (
                'id' => 176,
                'state_ut' => 'Karnataka',
                'constituency' => 'Chamarajanagar',
            ),
            176 => 
            array (
                'id' => 177,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bangalore Rural',
            ),
            177 => 
            array (
                'id' => 178,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bangalore North',
            ),
            178 => 
            array (
                'id' => 179,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bangalore Central',
            ),
            179 => 
            array (
                'id' => 180,
                'state_ut' => 'Karnataka',
                'constituency' => 'Bangalore South',
            ),
            180 => 
            array (
                'id' => 181,
                'state_ut' => 'Karnataka',
                'constituency' => 'Chikballapur',
            ),
            181 => 
            array (
                'id' => 182,
                'state_ut' => 'Karnataka',
                'constituency' => 'Kolar',
            ),
            182 => 
            array (
                'id' => 183,
                'state_ut' => 'Kerala',
                'constituency' => 'Kasaragod',
            ),
            183 => 
            array (
                'id' => 184,
                'state_ut' => 'Kerala',
                'constituency' => 'Kannur',
            ),
            184 => 
            array (
                'id' => 185,
                'state_ut' => 'Kerala',
                'constituency' => 'Vatakara',
            ),
            185 => 
            array (
                'id' => 186,
                'state_ut' => 'Kerala',
                'constituency' => 'Wayanad',
            ),
            186 => 
            array (
                'id' => 187,
                'state_ut' => 'Kerala',
                'constituency' => 'Kozhikode',
            ),
            187 => 
            array (
                'id' => 188,
                'state_ut' => 'Kerala',
                'constituency' => 'Malappuram',
            ),
            188 => 
            array (
                'id' => 189,
                'state_ut' => 'Kerala',
                'constituency' => 'Ponnani',
            ),
            189 => 
            array (
                'id' => 190,
                'state_ut' => 'Kerala',
                'constituency' => 'Palakkad',
            ),
            190 => 
            array (
                'id' => 191,
                'state_ut' => 'Kerala',
                'constituency' => 'Alathur',
            ),
            191 => 
            array (
                'id' => 192,
                'state_ut' => 'Kerala',
                'constituency' => 'Thrissur',
            ),
            192 => 
            array (
                'id' => 193,
                'state_ut' => 'Kerala',
                'constituency' => 'Chalakudy',
            ),
            193 => 
            array (
                'id' => 194,
                'state_ut' => 'Kerala',
                'constituency' => 'Ernakulam',
            ),
            194 => 
            array (
                'id' => 195,
                'state_ut' => 'Kerala',
                'constituency' => 'Idukki',
            ),
            195 => 
            array (
                'id' => 196,
                'state_ut' => 'Kerala',
                'constituency' => 'Kottayam',
            ),
            196 => 
            array (
                'id' => 197,
                'state_ut' => 'Kerala',
                'constituency' => 'Alappuzha',
            ),
            197 => 
            array (
                'id' => 198,
                'state_ut' => 'Kerala',
                'constituency' => 'Mavelikara',
            ),
            198 => 
            array (
                'id' => 199,
                'state_ut' => 'Kerala',
                'constituency' => 'Pathanamthitta',
            ),
            199 => 
            array (
                'id' => 200,
                'state_ut' => 'Kerala',
                'constituency' => 'Kollam',
            ),
            200 => 
            array (
                'id' => 201,
                'state_ut' => 'Kerala',
                'constituency' => 'Attingal',
            ),
            201 => 
            array (
                'id' => 202,
                'state_ut' => 'Kerala',
                'constituency' => 'Thiruvananthapuram',
            ),
            202 => 
            array (
                'id' => 203,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Morena',
            ),
            203 => 
            array (
                'id' => 204,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Bhind',
            ),
            204 => 
            array (
                'id' => 205,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Gwalior',
            ),
            205 => 
            array (
                'id' => 206,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Guna',
            ),
            206 => 
            array (
                'id' => 207,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Sagar',
            ),
            207 => 
            array (
                'id' => 208,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Tikamgarh',
            ),
            208 => 
            array (
                'id' => 209,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Damoh',
            ),
            209 => 
            array (
                'id' => 210,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Khajuraho',
            ),
            210 => 
            array (
                'id' => 211,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Satna',
            ),
            211 => 
            array (
                'id' => 212,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Rewa',
            ),
            212 => 
            array (
                'id' => 213,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Sidhi',
            ),
            213 => 
            array (
                'id' => 214,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Shahdol',
            ),
            214 => 
            array (
                'id' => 215,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Jabalpur',
            ),
            215 => 
            array (
                'id' => 216,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Mandla',
            ),
            216 => 
            array (
                'id' => 217,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Balaghat',
            ),
            217 => 
            array (
                'id' => 218,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Chhindwara',
            ),
            218 => 
            array (
                'id' => 219,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Hoshangabad',
            ),
            219 => 
            array (
                'id' => 220,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Vidisha',
            ),
            220 => 
            array (
                'id' => 221,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Bhopal',
            ),
            221 => 
            array (
                'id' => 222,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Rajgarh',
            ),
            222 => 
            array (
                'id' => 223,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Dewas',
            ),
            223 => 
            array (
                'id' => 224,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Ujjain',
            ),
            224 => 
            array (
                'id' => 225,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Mandsaur',
            ),
            225 => 
            array (
                'id' => 226,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Ratlam',
            ),
            226 => 
            array (
                'id' => 227,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Dhar',
            ),
            227 => 
            array (
                'id' => 228,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Indore',
            ),
            228 => 
            array (
                'id' => 229,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Khargone',
            ),
            229 => 
            array (
                'id' => 230,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Khandwa',
            ),
            230 => 
            array (
                'id' => 231,
                'state_ut' => 'Madhya Pradesh',
                'constituency' => 'Betul',
            ),
            231 => 
            array (
                'id' => 232,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Nandurbar',
            ),
            232 => 
            array (
                'id' => 233,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Dhule',
            ),
            233 => 
            array (
                'id' => 234,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Jalgaon',
            ),
            234 => 
            array (
                'id' => 235,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Raver',
            ),
            235 => 
            array (
                'id' => 236,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Buldhana',
            ),
            236 => 
            array (
                'id' => 237,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Akola',
            ),
            237 => 
            array (
                'id' => 238,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Amravati',
            ),
            238 => 
            array (
                'id' => 239,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Wardha',
            ),
            239 => 
            array (
                'id' => 240,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Ramtek',
            ),
            240 => 
            array (
                'id' => 241,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Nagpur',
            ),
            241 => 
            array (
                'id' => 242,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Bhandara?Gondiya',
            ),
            242 => 
            array (
                'id' => 243,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Gadchiroli?Chimur',
            ),
            243 => 
            array (
                'id' => 244,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Chandrapur',
            ),
            244 => 
            array (
                'id' => 245,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Yavatmal?Washim',
            ),
            245 => 
            array (
                'id' => 246,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Hingoli',
            ),
            246 => 
            array (
                'id' => 247,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Nanded',
            ),
            247 => 
            array (
                'id' => 248,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Parbhani',
            ),
            248 => 
            array (
                'id' => 249,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Jalna',
            ),
            249 => 
            array (
                'id' => 250,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Aurangabad',
            ),
            250 => 
            array (
                'id' => 251,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Dindori',
            ),
            251 => 
            array (
                'id' => 252,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Nashik',
            ),
            252 => 
            array (
                'id' => 253,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Palghar',
            ),
            253 => 
            array (
                'id' => 254,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Bhiwandi',
            ),
            254 => 
            array (
                'id' => 255,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Kalyan',
            ),
            255 => 
            array (
                'id' => 256,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Thane',
            ),
            256 => 
            array (
                'id' => 257,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Mumbai North',
            ),
            257 => 
            array (
                'id' => 258,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Mumbai North West',
            ),
            258 => 
            array (
                'id' => 259,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Mumbai North East',
            ),
            259 => 
            array (
                'id' => 260,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Mumbai North Central',
            ),
            260 => 
            array (
                'id' => 261,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Mumbai South Central',
            ),
            261 => 
            array (
                'id' => 262,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Mumbai South',
            ),
            262 => 
            array (
                'id' => 263,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Raigad',
            ),
            263 => 
            array (
                'id' => 264,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Maval',
            ),
            264 => 
            array (
                'id' => 265,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Pune',
            ),
            265 => 
            array (
                'id' => 266,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Baramati',
            ),
            266 => 
            array (
                'id' => 267,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Shirur',
            ),
            267 => 
            array (
                'id' => 268,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Ahmednagar',
            ),
            268 => 
            array (
                'id' => 269,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Shirdi',
            ),
            269 => 
            array (
                'id' => 270,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Beed',
            ),
            270 => 
            array (
                'id' => 271,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Osmanabad',
            ),
            271 => 
            array (
                'id' => 272,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Latur',
            ),
            272 => 
            array (
                'id' => 273,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Solapur',
            ),
            273 => 
            array (
                'id' => 274,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Madha',
            ),
            274 => 
            array (
                'id' => 275,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Sangli',
            ),
            275 => 
            array (
                'id' => 276,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Satara',
            ),
            276 => 
            array (
                'id' => 277,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Ratnagiri?Sindhudurg',
            ),
            277 => 
            array (
                'id' => 278,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Kolhapur',
            ),
            278 => 
            array (
                'id' => 279,
                'state_ut' => 'Maharashtra',
                'constituency' => 'Hatkanangle',
            ),
            279 => 
            array (
                'id' => 280,
                'state_ut' => 'Manipur',
                'constituency' => 'Inner Manipur',
            ),
            280 => 
            array (
                'id' => 281,
                'state_ut' => 'Manipur',
                'constituency' => 'Outer Manipur',
            ),
            281 => 
            array (
                'id' => 282,
                'state_ut' => 'Maghalaya',
                'constituency' => 'Shillong',
            ),
            282 => 
            array (
                'id' => 283,
                'state_ut' => 'Meghalaya',
                'constituency' => 'Tura',
            ),
            283 => 
            array (
                'id' => 284,
                'state_ut' => 'Mizoram',
                'constituency' => 'Mizoram',
            ),
            284 => 
            array (
                'id' => 285,
                'state_ut' => 'Nagaland',
                'constituency' => 'Nagaland',
            ),
            285 => 
            array (
                'id' => 286,
                'state_ut' => 'Odisha',
                'constituency' => 'Bargarh',
            ),
            286 => 
            array (
                'id' => 287,
                'state_ut' => 'Odisha',
                'constituency' => 'Sundargarh',
            ),
            287 => 
            array (
                'id' => 288,
                'state_ut' => 'Odisha',
                'constituency' => 'Sambalpur',
            ),
            288 => 
            array (
                'id' => 289,
                'state_ut' => 'Odisha',
                'constituency' => 'Keonjhar',
            ),
            289 => 
            array (
                'id' => 290,
                'state_ut' => 'Odisha',
                'constituency' => 'Mayurbhanj',
            ),
            290 => 
            array (
                'id' => 291,
                'state_ut' => 'Odisha',
                'constituency' => 'Balasore',
            ),
            291 => 
            array (
                'id' => 292,
                'state_ut' => 'Odisha',
                'constituency' => 'Bhadrak',
            ),
            292 => 
            array (
                'id' => 293,
                'state_ut' => 'Odisha',
                'constituency' => 'Jajpur',
            ),
            293 => 
            array (
                'id' => 294,
                'state_ut' => 'Odisha',
                'constituency' => 'Dhenkanal',
            ),
            294 => 
            array (
                'id' => 295,
                'state_ut' => 'Odisha',
                'constituency' => 'Bolangir',
            ),
            295 => 
            array (
                'id' => 296,
                'state_ut' => 'Odisha',
                'constituency' => 'Kalahandi',
            ),
            296 => 
            array (
                'id' => 297,
                'state_ut' => 'Odisha',
                'constituency' => 'Nabarangpur',
            ),
            297 => 
            array (
                'id' => 298,
                'state_ut' => 'Odisha',
                'constituency' => 'Kandhamal',
            ),
            298 => 
            array (
                'id' => 299,
                'state_ut' => 'Odisha',
                'constituency' => 'Cuttack',
            ),
            299 => 
            array (
                'id' => 300,
                'state_ut' => 'Odisha',
                'constituency' => 'Kendrapara',
            ),
            300 => 
            array (
                'id' => 301,
                'state_ut' => 'Odisha',
                'constituency' => 'Jagatsinghpur',
            ),
            301 => 
            array (
                'id' => 302,
                'state_ut' => 'Odisha',
                'constituency' => 'Puri',
            ),
            302 => 
            array (
                'id' => 303,
                'state_ut' => 'Odisha',
                'constituency' => 'Bhubaneswar',
            ),
            303 => 
            array (
                'id' => 304,
                'state_ut' => 'Odisha',
                'constituency' => 'Aska',
            ),
            304 => 
            array (
                'id' => 305,
                'state_ut' => 'Odisha',
                'constituency' => 'Berhampur',
            ),
            305 => 
            array (
                'id' => 306,
                'state_ut' => 'Odisha',
                'constituency' => 'Koraput',
            ),
            306 => 
            array (
                'id' => 307,
                'state_ut' => 'Punjab',
                'constituency' => 'Gurdaspur',
            ),
            307 => 
            array (
                'id' => 308,
                'state_ut' => 'Punjab',
                'constituency' => 'Amritsar',
            ),
            308 => 
            array (
                'id' => 309,
                'state_ut' => 'Punjab',
                'constituency' => 'Khadoor Sahib',
            ),
            309 => 
            array (
                'id' => 310,
                'state_ut' => 'Punjab',
                'constituency' => 'Jalandhar',
            ),
            310 => 
            array (
                'id' => 311,
                'state_ut' => 'Punjab',
                'constituency' => 'Hoshiarpur',
            ),
            311 => 
            array (
                'id' => 312,
                'state_ut' => 'Punjab',
                'constituency' => 'Anandpur Sahib',
            ),
            312 => 
            array (
                'id' => 313,
                'state_ut' => 'Punjab',
                'constituency' => 'Ludhiana',
            ),
            313 => 
            array (
                'id' => 314,
                'state_ut' => 'Punjab',
                'constituency' => 'Fatehgarh Sahib',
            ),
            314 => 
            array (
                'id' => 315,
                'state_ut' => 'Punjab',
                'constituency' => 'Faridkot',
            ),
            315 => 
            array (
                'id' => 316,
                'state_ut' => 'Punjab',
                'constituency' => 'Firozpur',
            ),
            316 => 
            array (
                'id' => 317,
                'state_ut' => 'Punjab',
                'constituency' => 'Bathinda',
            ),
            317 => 
            array (
                'id' => 318,
                'state_ut' => 'Punjab',
                'constituency' => 'Sangrur',
            ),
            318 => 
            array (
                'id' => 319,
                'state_ut' => 'Punjab',
                'constituency' => 'Patiala',
            ),
            319 => 
            array (
                'id' => 320,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Ganganagar',
            ),
            320 => 
            array (
                'id' => 321,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Bikaner',
            ),
            321 => 
            array (
                'id' => 322,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Churu',
            ),
            322 => 
            array (
                'id' => 323,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Jhunjhunu',
            ),
            323 => 
            array (
                'id' => 324,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Sikar',
            ),
            324 => 
            array (
                'id' => 325,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Jaipur Rural',
            ),
            325 => 
            array (
                'id' => 326,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Jaipur',
            ),
            326 => 
            array (
                'id' => 327,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Alwar',
            ),
            327 => 
            array (
                'id' => 328,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Bharatpur',
            ),
            328 => 
            array (
                'id' => 329,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Karauli?Dholpur',
            ),
            329 => 
            array (
                'id' => 330,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Dausa',
            ),
            330 => 
            array (
                'id' => 331,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Tonk?Sawai Madhopur',
            ),
            331 => 
            array (
                'id' => 332,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Ajmer',
            ),
            332 => 
            array (
                'id' => 333,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Nagaur',
            ),
            333 => 
            array (
                'id' => 334,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Pali',
            ),
            334 => 
            array (
                'id' => 335,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Jodhpur',
            ),
            335 => 
            array (
                'id' => 336,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Barmer',
            ),
            336 => 
            array (
                'id' => 337,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Jalore',
            ),
            337 => 
            array (
                'id' => 338,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Udaipur',
            ),
            338 => 
            array (
                'id' => 339,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Banswara',
            ),
            339 => 
            array (
                'id' => 340,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Chittorgarh',
            ),
            340 => 
            array (
                'id' => 341,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Rajsamand',
            ),
            341 => 
            array (
                'id' => 342,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Bhilwara',
            ),
            342 => 
            array (
                'id' => 343,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Kota',
            ),
            343 => 
            array (
                'id' => 344,
                'state_ut' => 'Rajasthan',
                'constituency' => 'Jhalawar?Baran',
            ),
            344 => 
            array (
                'id' => 345,
                'state_ut' => 'Sikkim',
                'constituency' => 'Sikkim',
            ),
            345 => 
            array (
                'id' => 346,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Thiruvallur',
            ),
            346 => 
            array (
                'id' => 347,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Chennai North',
            ),
            347 => 
            array (
                'id' => 348,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Chennai South',
            ),
            348 => 
            array (
                'id' => 349,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Chennai Central',
            ),
            349 => 
            array (
                'id' => 350,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Sriperumbudur',
            ),
            350 => 
            array (
                'id' => 351,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Kancheepuram',
            ),
            351 => 
            array (
                'id' => 352,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Arakkonam',
            ),
            352 => 
            array (
                'id' => 353,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Vellore',
            ),
            353 => 
            array (
                'id' => 354,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Krishnagiri',
            ),
            354 => 
            array (
                'id' => 355,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Dharmapuri',
            ),
            355 => 
            array (
                'id' => 356,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Tiruvannamalai',
            ),
            356 => 
            array (
                'id' => 357,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Arani',
            ),
            357 => 
            array (
                'id' => 358,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Villupuram',
            ),
            358 => 
            array (
                'id' => 359,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Kallakurichi',
            ),
            359 => 
            array (
                'id' => 360,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Salem',
            ),
            360 => 
            array (
                'id' => 361,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Namakkal',
            ),
            361 => 
            array (
                'id' => 362,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Erode',
            ),
            362 => 
            array (
                'id' => 363,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Tiruppur',
            ),
            363 => 
            array (
                'id' => 364,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Nilgiris',
            ),
            364 => 
            array (
                'id' => 365,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Coimbatore',
            ),
            365 => 
            array (
                'id' => 366,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Pollachi',
            ),
            366 => 
            array (
                'id' => 367,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Dindigul',
            ),
            367 => 
            array (
                'id' => 368,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Karur',
            ),
            368 => 
            array (
                'id' => 369,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Tiruchirappalli',
            ),
            369 => 
            array (
                'id' => 370,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Perambalur',
            ),
            370 => 
            array (
                'id' => 371,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Cuddalore',
            ),
            371 => 
            array (
                'id' => 372,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Chidambaram',
            ),
            372 => 
            array (
                'id' => 373,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Mayiladuturai',
            ),
            373 => 
            array (
                'id' => 374,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Nagapattinam',
            ),
            374 => 
            array (
                'id' => 375,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Thanjavur',
            ),
            375 => 
            array (
                'id' => 376,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Sivaganga',
            ),
            376 => 
            array (
                'id' => 377,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Madurai',
            ),
            377 => 
            array (
                'id' => 378,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Theni',
            ),
            378 => 
            array (
                'id' => 379,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Virudhunagar',
            ),
            379 => 
            array (
                'id' => 380,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Ramanathapuram',
            ),
            380 => 
            array (
                'id' => 381,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Thoothukudi',
            ),
            381 => 
            array (
                'id' => 382,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Tenkasi',
            ),
            382 => 
            array (
                'id' => 383,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Tirunelveli',
            ),
            383 => 
            array (
                'id' => 384,
                'state_ut' => 'Tamil Nadu',
                'constituency' => 'Kanyakumari',
            ),
            384 => 
            array (
                'id' => 385,
                'state_ut' => 'Telangana',
                'constituency' => 'Adilabad',
            ),
            385 => 
            array (
                'id' => 386,
                'state_ut' => 'Telangana',
                'constituency' => 'Peddapalle',
            ),
            386 => 
            array (
                'id' => 387,
                'state_ut' => 'Telangana',
                'constituency' => 'Karimnagar',
            ),
            387 => 
            array (
                'id' => 388,
                'state_ut' => 'Telangana',
                'constituency' => 'Nizamabad',
            ),
            388 => 
            array (
                'id' => 389,
                'state_ut' => 'Telangana',
                'constituency' => 'Zahirabad',
            ),
            389 => 
            array (
                'id' => 390,
                'state_ut' => 'Telangana',
                'constituency' => 'Medak',
            ),
            390 => 
            array (
                'id' => 391,
                'state_ut' => 'Telangana',
                'constituency' => 'Malkajgiri',
            ),
            391 => 
            array (
                'id' => 392,
                'state_ut' => 'Telangana',
                'constituency' => 'Secunderabad',
            ),
            392 => 
            array (
                'id' => 393,
                'state_ut' => 'Telangana',
                'constituency' => 'Hyderabad',
            ),
            393 => 
            array (
                'id' => 394,
                'state_ut' => 'Telangana',
                'constituency' => 'Chevella',
            ),
            394 => 
            array (
                'id' => 395,
                'state_ut' => 'Telangana',
                'constituency' => 'Mahbubnagar',
            ),
            395 => 
            array (
                'id' => 396,
                'state_ut' => 'Telangana',
                'constituency' => 'Nagarkurnool',
            ),
            396 => 
            array (
                'id' => 397,
                'state_ut' => 'Telangana',
                'constituency' => 'Nalgonda',
            ),
            397 => 
            array (
                'id' => 398,
                'state_ut' => 'Telangana',
                'constituency' => 'Bhongir',
            ),
            398 => 
            array (
                'id' => 399,
                'state_ut' => 'Telangana',
                'constituency' => 'Warangal',
            ),
            399 => 
            array (
                'id' => 400,
                'state_ut' => 'Telangana',
                'constituency' => 'Mahabubabad',
            ),
            400 => 
            array (
                'id' => 401,
                'state_ut' => 'Telangana',
                'constituency' => 'Khammam',
            ),
            401 => 
            array (
                'id' => 402,
                'state_ut' => 'Tripura',
                'constituency' => 'Tripura West',
            ),
            402 => 
            array (
                'id' => 403,
                'state_ut' => 'Tripura',
                'constituency' => 'Tripura East',
            ),
            403 => 
            array (
                'id' => 404,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Saharanpur',
            ),
            404 => 
            array (
                'id' => 405,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kairana',
            ),
            405 => 
            array (
                'id' => 406,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Muzaffarnagar',
            ),
            406 => 
            array (
                'id' => 407,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Bijnor',
            ),
            407 => 
            array (
                'id' => 408,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Nagina',
            ),
            408 => 
            array (
                'id' => 409,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Moradabad',
            ),
            409 => 
            array (
                'id' => 410,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Rampur',
            ),
            410 => 
            array (
                'id' => 411,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Sambhal',
            ),
            411 => 
            array (
                'id' => 412,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Amroha',
            ),
            412 => 
            array (
                'id' => 413,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Meerut',
            ),
            413 => 
            array (
                'id' => 414,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Baghpat',
            ),
            414 => 
            array (
                'id' => 415,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Ghaziabad',
            ),
            415 => 
            array (
                'id' => 416,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Gautam Buddha Nagar',
            ),
            416 => 
            array (
                'id' => 417,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Bulandshahr',
            ),
            417 => 
            array (
                'id' => 418,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Aligarh',
            ),
            418 => 
            array (
                'id' => 419,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Hathras',
            ),
            419 => 
            array (
                'id' => 420,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Mathura',
            ),
            420 => 
            array (
                'id' => 421,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Agra',
            ),
            421 => 
            array (
                'id' => 422,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Fatehpur Sikri',
            ),
            422 => 
            array (
                'id' => 423,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Firozabad',
            ),
            423 => 
            array (
                'id' => 424,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Mainpuri',
            ),
            424 => 
            array (
                'id' => 425,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Etah',
            ),
            425 => 
            array (
                'id' => 426,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Badaun',
            ),
            426 => 
            array (
                'id' => 427,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Aonla',
            ),
            427 => 
            array (
                'id' => 428,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Bareilly',
            ),
            428 => 
            array (
                'id' => 429,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Pilibhit',
            ),
            429 => 
            array (
                'id' => 430,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Shahjahanpur',
            ),
            430 => 
            array (
                'id' => 431,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kheri',
            ),
            431 => 
            array (
                'id' => 432,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Dhaurahra',
            ),
            432 => 
            array (
                'id' => 433,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Sitapur',
            ),
            433 => 
            array (
                'id' => 434,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Hardoi',
            ),
            434 => 
            array (
                'id' => 435,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Misrikh',
            ),
            435 => 
            array (
                'id' => 436,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Unnao',
            ),
            436 => 
            array (
                'id' => 437,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Mohanlalganj',
            ),
            437 => 
            array (
                'id' => 438,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Lucknow',
            ),
            438 => 
            array (
                'id' => 439,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Rae Bareli',
            ),
            439 => 
            array (
                'id' => 440,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Amethi',
            ),
            440 => 
            array (
                'id' => 441,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Sultanpur',
            ),
            441 => 
            array (
                'id' => 442,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Pratapgarh',
            ),
            442 => 
            array (
                'id' => 443,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Farrukhabad',
            ),
            443 => 
            array (
                'id' => 444,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Etawah',
            ),
            444 => 
            array (
                'id' => 445,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kannauj',
            ),
            445 => 
            array (
                'id' => 446,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kanpur Urban',
            ),
            446 => 
            array (
                'id' => 447,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Akbarpur',
            ),
            447 => 
            array (
                'id' => 448,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Jalaun',
            ),
            448 => 
            array (
                'id' => 449,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Jhansi',
            ),
            449 => 
            array (
                'id' => 450,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Hamirpur',
            ),
            450 => 
            array (
                'id' => 451,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Banda',
            ),
            451 => 
            array (
                'id' => 452,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Fatehpur',
            ),
            452 => 
            array (
                'id' => 453,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kaushambi',
            ),
            453 => 
            array (
                'id' => 454,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Phulpur',
            ),
            454 => 
            array (
                'id' => 455,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Allahabad',
            ),
            455 => 
            array (
                'id' => 456,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Barabanki',
            ),
            456 => 
            array (
                'id' => 457,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Faizabad',
            ),
            457 => 
            array (
                'id' => 458,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Ambedkar Nagar',
            ),
            458 => 
            array (
                'id' => 459,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Bahraich',
            ),
            459 => 
            array (
                'id' => 460,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kaiserganj',
            ),
            460 => 
            array (
                'id' => 461,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Shrawasti',
            ),
            461 => 
            array (
                'id' => 462,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Gonda',
            ),
            462 => 
            array (
                'id' => 463,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Domariyaganj',
            ),
            463 => 
            array (
                'id' => 464,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Basti',
            ),
            464 => 
            array (
                'id' => 465,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Sant Kabir Nagar',
            ),
            465 => 
            array (
                'id' => 466,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Maharajganj',
            ),
            466 => 
            array (
                'id' => 467,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Gorakhpur',
            ),
            467 => 
            array (
                'id' => 468,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Kushi Nagar',
            ),
            468 => 
            array (
                'id' => 469,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Deoria',
            ),
            469 => 
            array (
                'id' => 470,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Bansgaon',
            ),
            470 => 
            array (
                'id' => 471,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Lalganj',
            ),
            471 => 
            array (
                'id' => 472,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Azamgarh',
            ),
            472 => 
            array (
                'id' => 473,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Ghosi',
            ),
            473 => 
            array (
                'id' => 474,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Salempur',
            ),
            474 => 
            array (
                'id' => 475,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Ballia',
            ),
            475 => 
            array (
                'id' => 476,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Jaunpur',
            ),
            476 => 
            array (
                'id' => 477,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Machhlishahr',
            ),
            477 => 
            array (
                'id' => 478,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Ghazipur',
            ),
            478 => 
            array (
                'id' => 479,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Chandauli',
            ),
            479 => 
            array (
                'id' => 480,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Varanasi',
            ),
            480 => 
            array (
                'id' => 481,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Bhadohi',
            ),
            481 => 
            array (
                'id' => 482,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Mirzapur',
            ),
            482 => 
            array (
                'id' => 483,
                'state_ut' => 'Uttar Pradesh',
                'constituency' => 'Robertsganj',
            ),
            483 => 
            array (
                'id' => 484,
                'state_ut' => 'Uttarakhand',
                'constituency' => 'Tehri Garhwal',
            ),
            484 => 
            array (
                'id' => 485,
                'state_ut' => 'Uttarakhand',
                'constituency' => 'Garhwal',
            ),
            485 => 
            array (
                'id' => 486,
                'state_ut' => 'Uttarakhand',
                'constituency' => 'Almora',
            ),
            486 => 
            array (
                'id' => 487,
                'state_ut' => 'Uttarakhand',
                'constituency' => 'Nainital?Udhamsingh Nagar',
            ),
            487 => 
            array (
                'id' => 488,
                'state_ut' => 'Uttarakhand',
                'constituency' => 'Haridwar',
            ),
            488 => 
            array (
                'id' => 489,
                'state_ut' => 'West Bengal',
                'constituency' => 'Cooch Behar',
            ),
            489 => 
            array (
                'id' => 490,
                'state_ut' => 'West Bengal',
                'constituency' => 'Alipurduars',
            ),
            490 => 
            array (
                'id' => 491,
                'state_ut' => 'West Bengal',
                'constituency' => 'Jalpaiguri',
            ),
            491 => 
            array (
                'id' => 492,
                'state_ut' => 'West Bengal',
                'constituency' => 'Darjeeling',
            ),
            492 => 
            array (
                'id' => 493,
                'state_ut' => 'West Bengal',
                'constituency' => 'Raiganj',
            ),
            493 => 
            array (
                'id' => 494,
                'state_ut' => 'West Bengal',
                'constituency' => 'Balurghat',
            ),
            494 => 
            array (
                'id' => 495,
                'state_ut' => 'West Bengal',
                'constituency' => 'Maldaha Uttar',
            ),
            495 => 
            array (
                'id' => 496,
                'state_ut' => 'West Bengal',
                'constituency' => 'Maldaha Dakshin',
            ),
            496 => 
            array (
                'id' => 497,
                'state_ut' => 'West Bengal',
                'constituency' => 'Jangipur',
            ),
            497 => 
            array (
                'id' => 498,
                'state_ut' => 'West Bengal',
                'constituency' => 'Baharampur',
            ),
            498 => 
            array (
                'id' => 499,
                'state_ut' => 'West Bengal',
                'constituency' => 'Murshidabad',
            ),
            499 => 
            array (
                'id' => 500,
                'state_ut' => 'West Bengal',
                'constituency' => 'Krishnanagar',
            ),
        ));
        \DB::table('parliament')->insert(array (
            0 => 
            array (
                'id' => 501,
                'state_ut' => 'West Bengal',
                'constituency' => 'Ranaghat',
            ),
            1 => 
            array (
                'id' => 502,
                'state_ut' => 'West Bengal',
                'constituency' => 'Bangaon',
            ),
            2 => 
            array (
                'id' => 503,
                'state_ut' => 'West Bengal',
                'constituency' => 'Barrackpur',
            ),
            3 => 
            array (
                'id' => 504,
                'state_ut' => 'West Bengal',
                'constituency' => 'Dum Dum',
            ),
            4 => 
            array (
                'id' => 505,
                'state_ut' => 'West Bengal',
                'constituency' => 'Barasat',
            ),
            5 => 
            array (
                'id' => 506,
                'state_ut' => 'West Bengal',
                'constituency' => 'Basirhat',
            ),
            6 => 
            array (
                'id' => 507,
                'state_ut' => 'West Bengal',
                'constituency' => 'Jaynagar',
            ),
            7 => 
            array (
                'id' => 508,
                'state_ut' => 'West Bengal',
                'constituency' => 'Mathurapur',
            ),
            8 => 
            array (
                'id' => 509,
                'state_ut' => 'West Bengal',
                'constituency' => 'Diamond Harbour',
            ),
            9 => 
            array (
                'id' => 510,
                'state_ut' => 'West Bengal',
                'constituency' => 'Jadavpur',
            ),
            10 => 
            array (
                'id' => 511,
                'state_ut' => 'West Bengal',
                'constituency' => 'Kolkata Dakshin',
            ),
            11 => 
            array (
                'id' => 512,
                'state_ut' => 'West Bengal',
                'constituency' => 'Kolkata Uttar',
            ),
            12 => 
            array (
                'id' => 513,
                'state_ut' => 'West Bengal',
                'constituency' => 'Howrah',
            ),
            13 => 
            array (
                'id' => 514,
                'state_ut' => 'West Bengal',
                'constituency' => 'Uluberia',
            ),
            14 => 
            array (
                'id' => 515,
                'state_ut' => 'West Bengal',
                'constituency' => 'Srerampur',
            ),
            15 => 
            array (
                'id' => 516,
                'state_ut' => 'West Bengal',
                'constituency' => 'Hooghly',
            ),
            16 => 
            array (
                'id' => 517,
                'state_ut' => 'West Bengal',
                'constituency' => 'Arambag',
            ),
            17 => 
            array (
                'id' => 518,
                'state_ut' => 'West Bengal',
                'constituency' => 'Tamluk',
            ),
            18 => 
            array (
                'id' => 519,
                'state_ut' => 'West Bengal',
                'constituency' => 'Kanthi',
            ),
            19 => 
            array (
                'id' => 520,
                'state_ut' => 'West Bengal',
                'constituency' => 'Ghatal',
            ),
            20 => 
            array (
                'id' => 521,
                'state_ut' => 'West Bengal',
                'constituency' => 'Jhargram',
            ),
            21 => 
            array (
                'id' => 522,
                'state_ut' => 'West Bengal',
                'constituency' => 'Medinipur',
            ),
            22 => 
            array (
                'id' => 523,
                'state_ut' => 'West Bengal',
                'constituency' => 'Purulia',
            ),
            23 => 
            array (
                'id' => 524,
                'state_ut' => 'West Bengal',
                'constituency' => 'Bankura',
            ),
            24 => 
            array (
                'id' => 525,
                'state_ut' => 'West Bengal',
                'constituency' => 'Bishnupur',
            ),
            25 => 
            array (
                'id' => 526,
                'state_ut' => 'West Bengal',
                'constituency' => 'Bardhaman Purba',
            ),
            26 => 
            array (
                'id' => 527,
                'state_ut' => 'West Bengal',
                'constituency' => 'Bardhaman?Durgapur',
            ),
            27 => 
            array (
                'id' => 528,
                'state_ut' => 'West Bengal',
                'constituency' => 'Asansol',
            ),
            28 => 
            array (
                'id' => 529,
                'state_ut' => 'West Bengal',
                'constituency' => 'Bolpur',
            ),
            29 => 
            array (
                'id' => 530,
                'state_ut' => 'West Bengal',
                'constituency' => 'Birbhum',
            ),
            30 => 
            array (
                'id' => 531,
                'state_ut' => 'Andaman & Nicobar',
                'constituency' => 'Andaman & Nicobar',
            ),
            31 => 
            array (
                'id' => 532,
                'state_ut' => 'Chandigarh',
                'constituency' => 'Chandigarh',
            ),
            32 => 
            array (
                'id' => 533,
                'state_ut' => 'Dadra & Nagar Haveli',
                'constituency' => 'Dadra & Nagar Haveli',
            ),
            33 => 
            array (
                'id' => 534,
                'state_ut' => 'Daman & Diu',
                'constituency' => 'Daman & Diu',
            ),
            34 => 
            array (
                'id' => 535,
                'state_ut' => 'Lakshwadeep',
                'constituency' => 'Lakshwadeep',
            ),
            35 => 
            array (
                'id' => 536,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'Chandni Chowk',
            ),
            36 => 
            array (
                'id' => 537,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'North East Delhi',
            ),
            37 => 
            array (
                'id' => 538,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'East Delhi',
            ),
            38 => 
            array (
                'id' => 539,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'New Delhi',
            ),
            39 => 
            array (
                'id' => 540,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'North West Delhi',
            ),
            40 => 
            array (
                'id' => 541,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'West Delhi',
            ),
            41 => 
            array (
                'id' => 542,
                'state_ut' => 'NCT of Delhi',
                'constituency' => 'South Delhi',
            ),
            42 => 
            array (
                'id' => 543,
                'state_ut' => 'Puducherry',
                'constituency' => 'Puducherry',
            ),
        ));
        
        
    }
}