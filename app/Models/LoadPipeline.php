<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoadPipeline
 * @package App\Models
 *
 * @property-read int id
 * @property string path
 * @property string created_at
 * @property string updated_at
 */
class LoadPipeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];
}
