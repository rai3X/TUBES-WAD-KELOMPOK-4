<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $primaryKey = 'dokumenid';

    protected $fillable = [
        'namaFile',
        'jenisdokumen',
        'statusVerifikasi',
        'catatan',
        'filepath',
        'userid',
        'lombaid'
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