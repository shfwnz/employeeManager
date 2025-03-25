<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'jabatan';

    // Fillable 
    protected $fillable = [
        'nama_jabatan',
        'deskripsi'
    ];

    // One-to-Many
    public function jobs()
    {
        return $this->hasMany(Job::class, 'jabatan_id');
    }
}
