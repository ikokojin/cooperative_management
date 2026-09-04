<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membergovern_ids_tbl extends Model
{
    protected $table = 'membergovern_ids_tbls';

    protected $fillable = [
        'user_id',
        'sss_no',
        'philhealth_no',
        'pagibig_no',
        'tin_no',
    ];
}
