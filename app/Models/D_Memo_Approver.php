<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Memo_Approver extends Model
{
    protected $table = 'd_memo_approvers';
    protected $guarded = [];
    public $timestamps = true;
    // use SoftDeletes;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'id_memo', 'id');
    }

    public function employee_history()
    {
        return $this->belongsTo(Employee_History::class, 'id_employee', 'id_employee');
    }
}
