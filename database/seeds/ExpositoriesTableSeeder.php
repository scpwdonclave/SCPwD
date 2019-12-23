<?php

use Illuminate\Database\Seeder;

class ExpositoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expositories')->delete();
        
        \DB::table('expositories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'e_expository' => 'Locomotor Disability',
                'expository' => 'E001 - Locomotor Disability',
                'initials' => 'LD',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'e_expository' => 'Blindness /Visual Impairment',
                'expository' => 'E002 - Blindness /Visual Impairment',
                'initials' => 'BVI',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
            'e_expository' => 'Low-vision (Visual Impairment)',
            'expository' => 'E003 - Low-vision (Visual Impairment)',
                'initials' => 'LVVI',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'e_expository' => 'Speech and Hearing Impairment',
                'expository' => 'E004 - Speech and Hearing Impairment',
                'initials' => 'SHI',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}