<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nim';

    protected $fillable = [
        'emailmahasiswa',
        'jurusan',
        'userid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function pendaftaranLombas()
    {
        return $this->hasMany(PendaftaranLomba::class, 'mahasiswaid');
    }

    public function editProfil()
    {
        // Implementation for editing profile
    }
} 