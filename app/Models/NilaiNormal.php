<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiNormal extends Model
{
    use HasFactory;

    protected $table = 'nilai_normal';

    protected $fillable = [
        'test_name',
        'parameter',
        'unit',
        'normal_min',
        'normal_max',
        'gender',
        'age_min',
        'age_max',
        'notes',
        'referensi'
    ];
}
