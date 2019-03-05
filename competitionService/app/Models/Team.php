<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Team
 * @package App\Models
 * @version February 28, 2019, 12:49 pm UTC
 *
 * @property \App\Models\Competition category
 * @property \Illuminate\Database\Eloquent\Collection TeamMember
 * @property integer category_id
 * @property string team_name
 */
class Team extends Model
{
    use SoftDeletes;

    public $table = 'team';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'team_id';

    public $fillable = [
        'category_id',
        'team_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'team_id' => 'integer',
        'category_id' => 'integer',
        'team_name' => 'string'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function teamMembers()
    {
        return $this->hasMany(\App\Models\TeamMember::class);
    }

    public function delete_team_member() {
        $members=TeamMember::all()->where('team_id','=',$this->team_id);
        foreach ($members as $member) {
            $member->delete();
        }
    }
}
