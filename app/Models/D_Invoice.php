<?php

namespace App\Models;

use App\D_Item_Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class D_Invoice extends Model
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
        return $this->hasMany(D_Item_Invoice::class);
    }
}
