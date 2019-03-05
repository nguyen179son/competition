<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TeamMember
 * @package App\Models
 * @version February 26, 2019, 9:14 pm UTC
 *
 * @property \App\Models\Team team
 * @property \Illuminate\Database\Eloquent\Collection category
 * @property integer team_id
 * @property string member_name
 */
class TeamMember extends Model
{
    use SoftDeletes;

    public $table = 'team_member';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'member_id';

    public $fillable = [
        'team_id',
        'member_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'member_id' => 'integer',
        'team_id' => 'integer',
        'member_name' => 'string'
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
    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }
}
