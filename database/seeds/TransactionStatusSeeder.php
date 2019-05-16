<?php

use App\Models\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionStatus::create([
            'name' => 'Проверка анкеты'
        ]);
        TransactionStatus::create([
            'name' => 'Подписание документов'
        ]);
        TransactionStatus::create([
            'name' => 'Сделка заключена'
        ]);
        TransactionStatus::create([
            'name' => 'Сделка не заключена'
        ]);
    }
}
