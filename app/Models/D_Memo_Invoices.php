<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\D_Item_Invoice;

class D_Memo_Invoices extends Model
{
    //
    protected $table = 'd_memo_invoices';
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'npwp' => 'boolean',
        'ppn' => 'boolean',
        'grossup' => 'boolean',
        'ppn_value' => 'float',
        'pph_value' => 'float',
        'grossup_value' => 'float',
        'total' => 'float'
    ];

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'id_memo', 'id');
    }

    public function item_invoices()
    {
        return $this->hasMany(D_Item_Invoice::class, 'id_invoice', 'id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($memo) { // before delete() method call this
            $memo->item_invoices()->each(function ($item) {
                $item->delete(); // <-- direct deletion
            });
        });
    }
}
