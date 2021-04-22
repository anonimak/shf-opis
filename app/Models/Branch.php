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

    public static function getBranches($search = null)
    {
        $news = Self::select('*')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $news->where('branch_name', 'LIKE', '%' . $search . '%');
        }
        return $news->paginate(10);
    }
}
