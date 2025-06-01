<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranLomba extends Model
{
    use HasFactory;

    protected $primaryKey = 'pendaftaranid';

    protected $fillable = [
        'mahasiswaid',
        'lombaid',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswaid');
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'lombaid');
    }
} 