<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ref_Position extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_positions';

    protected $fillable = [
        "position_name", "id_department"
    ];
    use SoftDeletes;

    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department', 'id')->select('id', 'department_name');
    }

    public static function getRef_Positions($search = null)
    {
        $position = Self::select('*')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $position->where('position_name', 'LIKE', '%' . $search . '%');
        }
        return $position;
    }
}
