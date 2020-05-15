<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'created_at' => '2020-04-03 14:30:32',
                'dept_address' => '5th Floor, Paryavaran Bhawan, CGO Complex, Lodhi Road New Delhi - 110003 (India)',
                'dept_name' => 'Department of Empowerment of Persons with Disabilities (Divyangjan)',
                'id' => 1,
                'updated_at' => '2020-04-03 14:30:32',
            ),
            1 => 
            array (
                'created_at' => '2020-04-03 14:33:22',
                'dept_address' => 'Mumbai- Maharashtra. K.C. Marg, Bandra West, Reclamation- 400050',
                'dept_name' => 'Ali Yavar Jung National Institute of Speech and Hearing Disabilities',
                'id' => 2,
                'updated_at' => '2020-04-03 14:33:22',
            ),
            2 => 
            array (
                'created_at' => '2020-04-03 14:34:51',
                'dept_address' => 'Unit 11 & 12, Ground Floor, Prime Tower F-79 & 80, Okhla Phase -2, New Delhi - 110020',
                'dept_name' => 'National Handicapped Finance and Development Corporation (NHFDC)',
                'id' => 3,
                'updated_at' => '2020-04-03 14:34:51',
            ),
            3 => 
            array (
                'created_at' => '2020-04-03 14:38:27',
                'dept_address' => 'East Coast Road, Mutthukadu, Kovalam Post Chennai – 603112, Tamil Nadu',
                'dept_name' => 'National Institute for Empowerment of Persons with Multiple Disabilities',
                'id' => 4,
                'updated_at' => '2020-04-03 14:38:27',
            ),
            4 => 
            array (
                'created_at' => '2020-04-03 14:39:05',
                'dept_address' => 'B.T. Road, Bon – Hooghly, Kolkata – 700090',
                'dept_name' => 'National Institute for Locomotor Disabilities (Divyangjan)',
                'id' => 5,
                'updated_at' => '2020-04-03 14:39:05',
            ),
            5 => 
            array (
                'created_at' => '2020-04-03 14:41:15',
                'dept_address' => '4-Vishnu Digamber Marg New Delhi - 110002 (India)',
                'dept_name' => 'Pt. Deendayal Upadhyaya National Institute for Persons with Physical Disabilities',
                'id' => 6,
                'updated_at' => '2020-04-03 14:41:15',
            ),
        ));
        
        
    }
}