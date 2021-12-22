<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function position_now()
    {
        return $this->belongsTo(Employee_History::class, 'id_employee', 'id_employee')->select('id', 'id_employee', 'id_branch', 'id_position', 'year_started', 'year_finished')->where('year_started', '<', Carbon::now())->where('year_finished', '>', Carbon::now())->orWhere('year_finished', null);
    }
}
