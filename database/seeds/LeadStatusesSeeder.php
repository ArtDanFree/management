<?php

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeadStatus::create([
            'name' => 'Не обработан'
        ]);
        LeadStatus::create([
            'name' => 'На проверке'
        ]);
        LeadStatus::create([
            'name' => 'Сделка'
        ]);
        LeadStatus::create([
            'name' => 'Некачественный лид'
        ]);

    }
}
