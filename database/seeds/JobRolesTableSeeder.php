<?php

use Illuminate\Database\Seeder;

class JobRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('job_roles')->delete();
        
        \DB::table('job_roles')->insert(array (
            0 => 
            array (
                'id' => 3,
                'sector_id' => 1,
                'job_role' => 'Organic Grower',
                'qp_code' => 'PWD/AGR/Q1201',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:07:40',
                'updated_at' => '2019-09-16 09:07:40',
            ),
            1 => 
            array (
                'id' => 4,
                'sector_id' => 1,
                'job_role' => 'Dairy Farmer/Entrepreneur',
                'qp_code' => 'PWD/AGR/Q4101',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:10:00',
                'updated_at' => '2019-09-16 09:10:00',
            ),
            2 => 
            array (
                'id' => 5,
                'sector_id' => 1,
                'job_role' => 'Small Poultry Farmer',
                'qp_code' => 'PWD/AGR/Q4306',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:10:51',
                'updated_at' => '2019-09-16 09:10:51',
            ),
            3 => 
            array (
                'id' => 6,
                'sector_id' => 2,
                'job_role' => 'Sewing Machine Operator',
                'qp_code' => 'PWD/AMH/Q0301',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:11:33',
                'updated_at' => '2019-09-16 09:11:33',
            ),
            4 => 
            array (
                'id' => 7,
                'sector_id' => 2,
                'job_role' => 'Hand Embroiderer',
                'qp_code' => 'PWD/AMH/Q1001',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:12:27',
                'updated_at' => '2019-09-16 09:12:27',
            ),
            5 => 
            array (
                'id' => 8,
                'sector_id' => 2,
                'job_role' => 'Packer',
                'qp_code' => 'PWD/AMH/Q1407',
                'nsqf_level' => '3',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:14:17',
                'updated_at' => '2019-09-16 09:14:17',
            ),
            6 => 
            array (
                'id' => 9,
                'sector_id' => 3,
                'job_role' => 'Dealership Telecaller Sales Executive',
                'qp_code' => 'PWD/ASC/Q1011',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:15:10',
                'updated_at' => '2019-09-16 09:15:10',
            ),
            7 => 
            array (
                'id' => 10,
                'sector_id' => 3,
                'job_role' => 'Automotive Service Technician Level 3',
                'qp_code' => 'PWD/ASC/Q1401',
                'nsqf_level' => '3',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:15:59',
                'updated_at' => '2019-09-16 09:15:59',
            ),
            8 => 
            array (
                'id' => 11,
                'sector_id' => 3,
                'job_role' => 'Automotive Service Technician Level 4',
                'qp_code' => 'PWD/ASC/Q1402',
                'nsqf_level' => '4',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:16:26',
                'updated_at' => '2019-09-16 09:16:26',
            ),
            9 => 
            array (
                'id' => 12,
                'sector_id' => 4,
                'job_role' => 'Assistant Beauty Therapist',
                'qp_code' => 'PWD/BWS/Q0101',
                'nsqf_level' => '3',
                'hours' => '180',
                'full_marks' => '100',
                'pass_marks' => '30',
                'created_at' => '2019-09-16 09:17:21',
                'updated_at' => '2019-09-16 09:17:21',
            ),
        ));
        
        
    }
}