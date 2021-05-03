<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_branches';

    protected $fillable = ['branch_name', 'is_head'];

    use SoftDeletes;

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public static function getBranches($search = null)
    {
        $branch = Self::select('*')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $branch->where('branch_name', 'LIKE', '%' . $search . '%');
        }
        return $branch;
    }
}
