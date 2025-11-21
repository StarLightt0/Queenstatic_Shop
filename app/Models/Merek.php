<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
     use HasFactory;
     protected $primaryKey = 'id_merek';
    protected $fillable = ['nama_merek'];
}
