<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalCoaching extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_waktu',
        'jenis',
        'status',
        'catatan',
        'userid',
        'lombaid'
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'lombaid');
    }
} 