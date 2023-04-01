<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model {
    //
    protected $table = 'audit_trails';
    protected $guarded = ['id'];
    public $timestamps = false;
}
