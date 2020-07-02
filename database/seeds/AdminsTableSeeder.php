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
                'name' => 'Anup Srivastava',
                'email' => 'anup.srivastava@scpwd.in',
                'password' => '$2y$10$vakQaFxOJnsciritYVb/juaIP0yT3EQSKrte7tgg3bzJeFyKy8ao.', // Anup@123
                'supadmin' => 1,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bhupesh Sharma',
                'email' => 'bhupesh.sharma@scpwd.in',
                'password' => '$2y$10$W2MOtYCPrtiwIJlfZqMOX.j6fBp7kDh0xNGGQzhTVXE7Ql1FWssX.', // Bhupesh@123
                'supadmin' => 1,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Surabhi Raj Ekka',
                'email' => 'surabhiraj.ekka@scpwd.in',
                'password' => '$2y$10$DgGtw4XdrKkxikjPjir5w.4Y3bajhStHvTy/7ZSWwqG91O0cOPfTG', // Surabhi@123
                'supadmin' => 1,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Sanju Singh',
                'email' => 'sanju.singh@scpwd.in',
                'password' => '$2y$10$KkAxjMj4xuKTrFTMpiu.GukAK7BCJMmj5mXAfqzHeJANv23By2Ysi', // Sanju@123
                'supadmin' => 0,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Bharti Gupta',
                'email' => 'bharti.gupta@scpwd.in',
                'password' => '$2y$10$HmohvcVe5JCM4hvdjLTv8OgAydbf/e14cLDPieSQFHybnUlkRCCQ2', // Bharti@123
                'supadmin' => 0,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Jitin Sukhnani',
                'email' => 'jitin.sukhnani@scpwd.in',
                'password' => '$2y$10$h81Amf.ln1W8GtCi280ZR.3AudAY1ka0oEFOgGHFh99s6xrBDlSm.', // Jitin@123
                'supadmin' => 0,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Himanshu Shekhar',
                'email' => 'himanshu.shekhar@scpwd.in',
                'password' => '$2y$10$7s62ue6ABztXDeJ/fXzL6OKkrmhZ4kT1r4f08NnoMCxGHSO05nCGO', // Himanshu@123
                'supadmin' => 0,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
        
        
    }
}