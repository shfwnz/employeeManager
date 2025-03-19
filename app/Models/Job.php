<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $fillable = [
        'karyawan_id',
        'divisi_id',
        'jabatan_id',
        'tanggal_bergabung',
        'gaji',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
    public function divisi()
    {
        return $this->belongsTo(Division::class, 'divisi_id');
    }
    public function jabatan()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }
}
