<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\D_Item_Invoice;

class D_Invoices extends Model
{
    //
    protected $table = 'd_invoices';
    protected $guarded = [];
    public $timestamps = true;

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'id_memo', 'id');
    }

    public function item_invoices()
    {
        return $this->hasMany(D_Item_Invoice::class, 'id_invoice', 'id');
    }
}
