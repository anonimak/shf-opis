<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ref_Module_Approver_Detail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'd_module_approvers';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = [
        'laravel_through_key'
    ];

    public function approver()
    {
        return $this->belongsTo(Ref_Module_Approver::class, 'id_ref_module_approver', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Ref_Position::class, 'id_ref_position', 'id');
    }
}
