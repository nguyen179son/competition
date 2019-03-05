<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Mc
 * @package App\Models
 * @version February 26, 2019, 9:13 pm UTC
 *
 * @property \App\Models\Competition category
 * @property integer category_id
 * @property string mc_name
 */
class Mc extends Model
{
    use SoftDeletes;

    public $table = 'mc';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'mc_id';

    public $fillable = [
        'category_id',
        'mc_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'mc_id' => 'integer',
        'category_id' => 'integer',
        'mc_name' => 'string'
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
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
