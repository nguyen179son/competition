<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DanceGenre
 * @package App\Models
 * @version February 28, 2019, 12:10 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection category
 * @property string dance_genre_name
 */
class DanceGenre extends Model
{
    use SoftDeletes;

    public $table = 'dance_genre';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'dance_genre_id';

    public $fillable = [
        'dance_genre_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'dance_genre_id' => 'integer',
        'dance_genre_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function competitions()
    {
        return $this->belongsToMany(\App\Models\Competition::class, 'category');
    }
}
