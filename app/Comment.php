<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function ticket()
   {
       return $this->belongsTo('App\Ticket');
   }
  //  In addition, we may want to make all columns mass assignable except the id column:
   protected $guarded = ['id'];
}
