<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Prize
 * @package App\Models
 * @version February 26, 2019, 9:13 pm UTC
 *
 * @property \App\Models\Competition category
 * @property integer category_id
 * @property string title
 * @property string reward
 */
class Prize extends Model
{
    use SoftDeletes;

    public $table = 'prize';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'prize_id';


    public $fillable = [
        'category_id',
        'title',
        'reward'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'prize_id' => 'integer',
        'category_id' => 'integer',
        'title' => 'string',
        'reward' => 'string'
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
