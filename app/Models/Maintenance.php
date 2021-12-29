<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Maintenance extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_maintenance';

    protected $fillable = [
        "msg", "status"
    ];

    public static function getMsgMaintenance()
    {
        $maintenance = Self::select('*')
            ->orderBy('id', 'desc');
        return $maintenance;
    }

    public static function getMsgMaintenanceFirstShow()
    {
        $maintenance = Self::select('*')
            ->orderBy('id', 'desc')
            ->where('status','show')->first();
        return $maintenance;
    }
}
