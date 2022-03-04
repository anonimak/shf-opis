<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;

class D_Item_Invoice extends Model
{
    //
    protected $table = 'd_item_invoice';
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];

    public function invoice()
    {
        return $this->belongsTo(D_Memo_Invoices::class, 'id_invoice', 'id');
    }

    public function getTotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
