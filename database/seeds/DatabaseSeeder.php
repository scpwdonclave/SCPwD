<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(StateDistrictTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(ParliamentTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(ExpositoriesTableSeeder::class);
        $this->call(ExpositoryJobRoleTableSeeder::class);
        $this->call(JobRolesTableSeeder::class);
        $this->call(JobQualificationsTableSeeder::class);
        $this->call(SchemesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(OldCandidatesTableSeeder::class);
    }
}
