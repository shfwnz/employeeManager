<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $fillable = [
        'nama_jabatan',
        'deskripsi'
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'jabatan_id');
    }
}
