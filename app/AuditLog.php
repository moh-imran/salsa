<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AuditLog extends Model
{
    //protected $table = 'audit_logs';
    protected $fillable = [
        'table_name',
        'record_id',
        'sync_version',
        'last_version',
        'current_version',
    ];
}
