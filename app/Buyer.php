<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\Basketitem;
use App\Transformers\BuyerTransformer;

class Buyer extends User
{
    public $table = "users";  // BYL BLAD BEZ TEGO NIE WYKRYWALO ZE BUYER ODNOSI SIE DO USERA

    public $transformer = BuyerTransformer::class;
    
    public function transactions() {
      return $this->hasMany(Transaction::class);
    }
    public function basketitems() {
      return $this->hasMany(Basketitem::class);
    }

}
