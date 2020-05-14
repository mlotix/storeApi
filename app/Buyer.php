<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\Basketitem;

class Buyer extends User
{
    public $table = "users";  // BYL BLAD BEZ TEGO NIE WYKRYWALO ZE BUYER ODNOSI SIE DO USERA
    public function transactions() {
      return $this->hasMany(Transaction::class);
    }
    public function basketitems() {
      return $this->hasMany(Basketitem::class);
    }

}
