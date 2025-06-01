<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'users';

    /**
     * Tentukan kolom-kolom yang bisa diisi secara massal:
     * 'name', 'email', 'password', dan 'role'.
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',  
        'role', // admin, mahasiswa, dimwad
    ];    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function articles()
    {
        return $this->hasMany(\App\Models\Article::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'userid');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'userid');
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'userid');
    }

    public function jadwalCoachings()
    {
        return $this->hasMany(JadwalCoaching::class, 'userid');
    }
}
