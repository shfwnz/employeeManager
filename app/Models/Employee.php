<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'karyawan';

    // Fillable 
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'email',
        'foto',
        'status',
    ];

    // One-to-Many
    public function jobs()
    {
        return $this->hasMany(Job::class, 'karyawan_id');
    }

    // One-to-One
    public function division()
    {
        return $this->hasOneThrough(Division::class, Job::class, 'karyawan_id', 'id', 'id', 'divisi_id');
    }

    // One-to-One
    public function position()
    {
        return $this->hasOneThrough(Position::class, Job::class, 'karyawan_id', 'id', 'id', 'jabatan_id');
    }
}
