<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class D_Po_Approver extends Model
{
    protected $table = 'd_po_approver';

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }
}
