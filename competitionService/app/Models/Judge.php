<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Judge
 * @package App\Models
 * @version February 28, 2019, 4:55 pm UTC
 *
 * @property \App\Models\Category category
 * @property integer category_id
 * @property string judge_name
 */
class Judge extends Model
{
    use SoftDeletes;

    public $table = 'judge';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'judge_id';


    public $fillable = [
        'category_id',
        'judge_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'judge_id' => 'integer',
        'category_id' => 'integer',
        'judge_name' => 'string'
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
