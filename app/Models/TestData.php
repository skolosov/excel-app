<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TestData
 * @package App\Models
 *
 * @property-read int id
 * @property string name
 * @property string date
 */
class TestData extends Model
{
    protected $table = 'test_data';

    protected $fillable = [
        'name',
        'date',
    ];

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];
}
