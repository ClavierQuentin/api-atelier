<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeuxiemeBanniere extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'titre',
        'texte'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
