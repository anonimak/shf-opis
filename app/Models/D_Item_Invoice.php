<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Item_Invoice extends Model
{
    //
    protected $table = 'd_item_invoice';
    protected $guarded = [];
    public $timestamps = true;

    public function invoice()
    {
        return $this->belongsTo(D_Invoices::class, 'id_invoice', 'id');
    }
}
