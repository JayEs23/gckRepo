<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    // Define the table and primary key for the model
    protected $table = 'documents';
    protected $primaryKey = 'id';

    // Allow mass assignment for the following attributes
    protected $fillable = ['request_id', 'path', 'name', 'size'];

    // Define the request relationship
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    /**
     * Fetch the documents for a given request.
     *
     * @param  int  $requestId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function fetchByRequestId($requestId)
    {
        return static::where('request_id', $requestId)->get();
    }
}
