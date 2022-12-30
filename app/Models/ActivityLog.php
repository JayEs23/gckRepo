<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Define the table and primary key for the model
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';

    // Allow mass assignment for the following attributes
    protected $fillable = ['user_id', 'description'];

    // Define the user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
