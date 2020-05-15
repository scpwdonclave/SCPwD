<?php

use Illuminate\Database\Seeder;

class SchemesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schemes')->delete();
        
        \DB::table('schemes')->insert(array (
            0 => 
            array (
                'cert_format' => 'DEPwD/',
                'cert_name' => 'SIPDA.jpg',
                'created_at' => '2020-03-03 17:00:29',
                'dept_id' => 1,
                'disability' => 1,
                'fin_yr' => 1,
                'id' => 1,
                'invoice_on' => 1,
                'scheme' => 'DEPwD-SIPDA 19-20',
                'status' => 1,
                'updated_at' => '2020-03-03 17:00:29',
                'year' => '2019-20',
            ),
            1 => 
            array (
                'cert_format' => 'SCPwD/NHFDC/',
                'cert_name' => 'NHFDC.jpg',
                'created_at' => '2020-04-03 15:53:31',
                'dept_id' => 3,
                'disability' => 1,
                'fin_yr' => 1,
                'id' => 2,
                'invoice_on' => 1,
                'scheme' => 'NHFDC-SIPDA 18-19',
                'status' => 1,
                'updated_at' => '2020-04-03 15:53:31',
                'year' => '2018-19',
            ),
        ));
        
        
    }
}