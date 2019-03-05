<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Dj
 * @package App\Models
 * @version February 26, 2019, 9:13 pm UTC
 *
 * @property \App\Models\Competition competition
 * @property \Illuminate\Database\Eloquent\Collection category
 * @property integer competition_id
 * @property string dj_name
 */
class Dj extends Model
{
    use SoftDeletes;

    public $table = 'dj';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'dj_id';

    public $fillable = [
        'category_id',
        'dj_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'dj_id' => 'integer',
        'category_id' => 'integer',
        'dj_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function competition()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
