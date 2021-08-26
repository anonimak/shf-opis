<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Memo_Acknowledge extends Model
{
    protected $table = 'd_memo_acknowledge';
    protected $guarded = [];
    public $timestamps = true;
    // use SoftDeletes;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }
}
