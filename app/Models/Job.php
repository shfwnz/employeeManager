<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';

    protected $fillable = [
        'karyawan_id',
        'divisi_id',
        'jabatan_id',
        'tanggal_bergabung',
        'gaji',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'divisi_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }
}
