<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Memo_Payments extends Model
{
    //
    protected $table = 'd_memo_payments';
    protected $guarded = [];
    public $timestamps = true;

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'id_memo', 'id');
    }
}
