<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    // table name
    protected $table = 'divisi';

    // Fillable
    protected $fillable = [
        'nama_divisi',
        'deskripsi'
    ];

    // one-to-many
    public function jobs()
    {
        return $this->hasMany(Job::class, 'divisi_id');
    }
}
