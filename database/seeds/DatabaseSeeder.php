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

        $this->call(NotificationsSeeder::class);
        factory(\App\Models\City::class, 20)->create();
        $this->call(TransactionStatusSeeder::class);
        $this->call(LeadStatusesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UserCitySeeder::class);
        $this->call(LeadRejectionReasonsSeeder::class);
        factory(\App\Models\User::class, 4)->create();
        factory(\App\Models\Lead::class, 100)->create();
        $this->call(LeadTypesSeeder::class);

    }
}
