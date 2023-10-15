<?php

namespace App\Models\FilesystemS3;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory, HasUuids;
    
    /**
     * fillale
     *
     * @var array
     */
    public $fillable = [
        "filename", "user_id"
    ];
    
    /**
     * keyType
     *
     * @var string
     */
    protected $keyType = "string";    


    
    /**
     * incrementing
     *
     * @var bool
     */
    public $incrementing = false;
}
