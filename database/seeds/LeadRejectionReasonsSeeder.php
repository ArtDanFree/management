<?php

use Illuminate\Database\Seeder;

class LeadRejectionReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\LeadRejectionReason::create([
            'name' => 'Хотят больше, чем можем дать'
        ]);
        \App\Models\LeadRejectionReason::create([
            'name' => 'Иностранец'
        ]);
        \App\Models\LeadRejectionReason::create([
            'name' => 'Не собственник'
        ]);
        \App\Models\LeadRejectionReason::create([
            'name' => 'Недозвон'
        ]);
        \App\Models\LeadRejectionReason::create([
            'name' => 'Отсутствует залог'
        ]);
        \App\Models\LeadRejectionReason::create([
            'name' => 'Другое'
        ]);
    }
}
