<?php

use Illuminate\Database\Seeder;
use App\Transaction;
class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::flushEventListeners();
        factory(Transaction::class, 300)->create();
    }
}
