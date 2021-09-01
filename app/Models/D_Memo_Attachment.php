<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class D_Memo_Attachment extends Model
{
    protected $table = 'd_memo_attachments';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::deleting(
            function ($attach) {
                Storage::delete('public/uploads/memo/attach/' . $attach->name);
            }
        );
    }
}
