<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class D_Item_Invoice extends Model
{
    //
    protected $table = 'd_item_invoices';
    protected $guarded = [];
    public $timestamps = true;

    public function invoice()
    {
        return $this->belongsTo(D_Invoice::class, 'id_invoice', 'id');
    }
}
