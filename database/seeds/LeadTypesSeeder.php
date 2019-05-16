<?php

use Illuminate\Database\Seeder;

class LeadTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \App\Models\TypeDeposit::create([
          'name' => 'Недвижимость'
      ]);
      \App\Models\TypeDeposit::create([
          'name' => 'Автомобиль'
      ]);
    }
}
