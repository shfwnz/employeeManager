<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $table = 'jabatan';

    protected $fillable = [
        'karyawan_id',
        'divisi_id',
        'jabatan_id',
        'tanggal_bergabung',
        'gaji',
    ];
}
