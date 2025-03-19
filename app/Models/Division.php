<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisi';

    protected $fillable = [
        'nama_divisi',
        'deskripsi'
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'divisi_id');
    }
}
