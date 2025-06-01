<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    // protected $table = 'lomba';

    protected $fillable = [
        'nama_lomba',
        'penyelenggara',
        'tingkat',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relationship with Dokumen
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'lombaid');
    }

    // Relationship with Pendaftaran
    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranLomba::class, 'lomba_id');
    }

    public function jadwalCoachings()
    {
        return $this->hasMany(JadwalCoaching::class, 'lombaid');
    }
} 