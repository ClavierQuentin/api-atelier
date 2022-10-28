<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function texteAccueils()
    {
        return $this->hasMany(TexteAccueil::class);
    }

    public function premiereBannieres()
    {
        return $this->hasMany(PremiereBanniere::class);
    }

    public function deuxiemeBannieres()
    {
        return $this->hasMany(DeuxiemeBanniere::class);
    }
    public function troisiemeBannieres()
    {
        return $this->hasMany(TroisiemeBanniere::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function newsletter()
    {
        return $this->hasMany(Newsletter::class);
    }
}
