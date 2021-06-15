<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamadas extends Model
{
    use HasFactory;

    protected $fillable = ['senha_id', 'guiche_id', 'exibe_master', 'som'];
}
