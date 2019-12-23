<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admins')->delete();
        
        \DB::table('admins')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => '$2y$10$0qBeLAhWQ.WLYN98MPIV9eiqtEBUtzZ6Rm.wa9uAGLc9YW0ARTHEK',
                'supadmin' => 1,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => '2019-12-16 09:13:37',
                'updated_at' => '2019-12-16 13:36:48',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Shouvik Mohanta',
                'email' => 'shouvik@gmail.com',
                'password' => '$2y$10$0qBeLAhWQ.WLYN98MPIV9eiqtEBUtzZ6Rm.wa9uAGLc9YW0ARTHEK',
                'supadmin' => 0,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => '2019-12-16 09:13:37',
                'updated_at' => '2019-12-16 13:36:48',
            ),
        ));
        
        
    }
}