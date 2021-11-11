<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Payment_Approver extends Model
{
    protected $table = 'd_payment_approver';

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }
}
