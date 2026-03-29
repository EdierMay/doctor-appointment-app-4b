<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'total_rows',
        'processed_rows',
        'status',
        'error_message',
    ];
}
