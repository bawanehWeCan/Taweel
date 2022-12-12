<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function dreams(){
        return $this->hasMany(Dream::class)->orderBy('created_at','desc');
    }
}
