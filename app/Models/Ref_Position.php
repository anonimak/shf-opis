<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function emp_history()
    {
        return $this->hasMany(Employee_History::class, 'id_position', 'id');
    }

    public function position_now()
    {
        return $this->hasOne(Employee_History::class, 'id_position')->select('id', 'id_employee', 'id_branch', 'id_position', 'year_started', 'year_finished')->where('year_started', '<', Carbon::now())->where('year_finished', '>', Carbon::now())->orWhere('year_finished', null);
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
