<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'section_id',
        'product',
        'Amount_collection',
        'Amount_commission',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'note',
        'status',
        'value_status',
    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
