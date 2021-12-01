<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Data_Cost_Total extends Model
{
    //
    protected $table = 'm_data_cost_total';
    protected $guarded = [];
    public $timestamps = true;

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'id_memo', 'id');
    }
}
