<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public  $timestamps = false;
    protected $fillable = [
        'section_name',
        'description',
        'created_by'
    ];
}
