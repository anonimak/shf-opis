<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ref_Module_Approver extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_module_approvers';

    use SoftDeletes;
    protected $guarded = [];
    protected $hidden = [
        'laravel_through_key'
    ];

    public function detailApprover()
    {
        return $this->hasMany(Ref_Module_Approver_Detail::class, 'id_ref_module_approver', 'id');
    }

    public static function getRef_Approver($search = null)
    {
        $position = Self::select('*')->with(['detailApprover' => function ($query) {
            return $query->select('id', 'id_ref_module_approver', 'id_ref_position')->with(['position' => function ($q) {
                return $q->select('id', 'position_name');
            }])->orderBy('idx', 'ASC');
        }])
            ->orderBy('id', 'desc');

        if ($search) {
            $position->where('name', 'LIKE', '%' . $search . '%');
        }
        return $position;
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($approver) { // before delete() method call this
            $approver->detailApprover()->each(function ($detail) {
                $detail->delete(); // <-- direct deletion
            });
        });
    }
}
