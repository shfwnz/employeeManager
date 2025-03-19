<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

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

    public function jobs()
    {
        return $this->hasMany(Job::class, 'karyawan_id');
    }
}
