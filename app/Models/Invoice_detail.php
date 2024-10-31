<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_Invoice',
        'invoice_number',
        'section',
        'product',
        'note',
        'status',
        'value_status',
        'user',
    ];

    public function sections()
    {
        return $this->belongsTo(Section::class);
    }
}
