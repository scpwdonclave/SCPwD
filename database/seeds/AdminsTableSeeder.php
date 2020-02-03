<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Sayan Saha',
                'email' => 'sayan@gmail.com',
                'password' => '$2y$10$0qBeLAhWQ.WLYN98MPIV9eiqtEBUtzZ6Rm.wa9uAGLc9YW0ARTHEK',
                'supadmin' => 0,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
        
        
    }
}