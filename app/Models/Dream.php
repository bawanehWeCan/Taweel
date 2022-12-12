<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dream extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    //TODO :: j nvlknlkvcnlckv
    public function replays(){
        return $this->hasMany(Replay::class);
    }

   

    public function cat(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function client(){
        return $this->belongsTo(User::class,'usr_id');
    }
}
