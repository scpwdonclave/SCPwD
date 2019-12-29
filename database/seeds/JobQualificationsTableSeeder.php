<?php

use Illuminate\Database\Seeder;

class JobQualificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('job_qualifications')->delete();
        
        \DB::table('job_qualifications')->insert(array (
            0 => 
            array (
                'id' => 2,
                'job_id' => 3,
                'qualification' => '11th to 12th',
                'sector_exp' => '3',
                'teaching_exp' => '3',
                'created_at' => '2019-12-29 06:17:21',
                'updated_at' => '2019-12-29 06:17:21',
            ),
            1 => 
            array (
                'id' => 3,
                'job_id' => 4,
                'qualification' => 'Graduate',
                'sector_exp' => '1',
                'teaching_exp' => '2',
                'created_at' => '2019-12-29 06:17:33',
                'updated_at' => '2019-12-29 06:17:33',
            ),
            2 => 
            array (
                'id' => 4,
                'job_id' => 5,
                'qualification' => '9th to 10th',
                'sector_exp' => '1',
                'teaching_exp' => '1',
                'created_at' => '2019-12-29 06:17:53',
                'updated_at' => '2019-12-29 06:17:53',
            ),
            3 => 
            array (
                'id' => 5,
                'job_id' => 6,
                'qualification' => 'Under Graduate',
                'sector_exp' => '.5',
                'teaching_exp' => '2.5',
                'created_at' => '2019-12-29 06:18:11',
                'updated_at' => '2019-12-29 06:18:11',
            ),
            4 => 
            array (
                'id' => 6,
                'job_id' => 7,
                'qualification' => 'Post Graduate',
                'sector_exp' => '2',
                'teaching_exp' => '2.5',
                'created_at' => '2019-12-29 06:18:38',
                'updated_at' => '2019-12-29 06:18:38',
            ),
            5 => 
            array (
                'id' => 7,
                'job_id' => 8,
                'qualification' => 'Post Graduate',
                'sector_exp' => '1',
                'teaching_exp' => '1.5',
                'created_at' => '2019-12-29 06:19:02',
                'updated_at' => '2019-12-29 06:19:02',
            ),
            6 => 
            array (
                'id' => 8,
                'job_id' => 9,
                'qualification' => 'ITI',
                'sector_exp' => '2.5',
                'teaching_exp' => '2',
                'created_at' => '2019-12-29 06:19:29',
                'updated_at' => '2019-12-29 06:19:29',
            ),
            7 => 
            array (
                'id' => 9,
                'job_id' => 10,
                'qualification' => 'Un Educated',
                'sector_exp' => '1',
                'teaching_exp' => '1',
                'created_at' => '2019-12-29 06:19:44',
                'updated_at' => '2019-12-29 06:19:44',
            ),
            8 => 
            array (
                'id' => 10,
                'job_id' => 11,
                'qualification' => '11th to 12th',
                'sector_exp' => '1.5',
                'teaching_exp' => '2.5',
                'created_at' => '2019-12-29 06:20:03',
                'updated_at' => '2019-12-29 06:20:03',
            ),
            9 => 
            array (
                'id' => 11,
                'job_id' => 12,
                'qualification' => 'Polytechnic',
                'sector_exp' => '1',
                'teaching_exp' => '1',
                'created_at' => '2019-12-29 06:20:20',
                'updated_at' => '2019-12-29 06:20:20',
            ),
            10 => 
            array (
                'id' => 14,
                'job_id' => 3,
                'qualification' => 'Under Graduate',
                'sector_exp' => '1',
                'teaching_exp' => '1',
                'created_at' => '2019-12-29 06:59:11',
                'updated_at' => '2019-12-29 06:59:11',
            ),
            11 => 
            array (
                'id' => 15,
                'job_id' => 3,
                'qualification' => 'Un Educated',
                'sector_exp' => '1',
                'teaching_exp' => '1',
                'created_at' => '2019-12-29 06:59:25',
                'updated_at' => '2019-12-29 06:59:25',
            ),
            12 => 
            array (
                'id' => 16,
                'job_id' => 4,
                'qualification' => '11th to 12th',
                'sector_exp' => '.5',
                'teaching_exp' => '2',
                'created_at' => '2019-12-29 06:59:59',
                'updated_at' => '2019-12-29 06:59:59',
            ),
            13 => 
            array (
                'id' => 17,
                'job_id' => 5,
                'qualification' => 'ITI',
                'sector_exp' => '2',
                'teaching_exp' => '3',
                'created_at' => '2019-12-29 07:00:21',
                'updated_at' => '2019-12-29 07:00:21',
            ),
            14 => 
            array (
                'id' => 18,
                'job_id' => 6,
                'qualification' => 'Un Educated',
                'sector_exp' => '2',
                'teaching_exp' => '2',
                'created_at' => '2019-12-29 07:00:34',
                'updated_at' => '2019-12-29 07:00:34',
            ),
            15 => 
            array (
                'id' => 19,
                'job_id' => 7,
                'qualification' => 'Diploma',
                'sector_exp' => '2',
                'teaching_exp' => '1',
                'created_at' => '2019-12-29 07:00:49',
                'updated_at' => '2019-12-29 07:00:49',
            ),
            16 => 
            array (
                'id' => 20,
                'job_id' => 3,
                'qualification' => 'Diploma',
                'sector_exp' => '1',
                'teaching_exp' => '2',
                'created_at' => '2019-12-29 07:01:03',
                'updated_at' => '2019-12-29 07:01:03',
            ),
            17 => 
            array (
                'id' => 21,
                'job_id' => 4,
                'qualification' => 'Un Educated',
                'sector_exp' => '4',
                'teaching_exp' => '2',
                'created_at' => '2019-12-29 07:01:16',
                'updated_at' => '2019-12-29 07:01:16',
            ),
        ));
        
        
    }
}