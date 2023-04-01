<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadExcel extends Model
{
    protected $table = 'download_excel';
    protected $guarded = ['id','created_at','updated_at'];
}
