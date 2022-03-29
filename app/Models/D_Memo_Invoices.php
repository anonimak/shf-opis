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

    public function getRawTotalAttribute()
    {
        $items = D_Item_Invoice::where('id_invoice', $this->attributes['id'])->get();
        $sum = $items->sum(function ($item) {
            return $item->total;
        });
        return $sum;
    }

    public function getTotalBarangAttribute()
    {
        $items = D_Item_Invoice::where('id_invoice', $this->attributes['id'])->where('type', 'barang')->get();
        $sum = $items->sum(function ($item) {
            return $item->total;
        });
        return $sum;
    }

    public function getTotalJasaAttribute()
    {
        $items = D_Item_Invoice::where('id_invoice', $this->attributes['id'])->where('type', 'jasa')->get();
        $sum = $items->sum(function ($item) {
            return $item->total;
        });
        return $sum;
    }

    public function getObjOthersAttribute()
    {
        return json_decode($this->others);
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
