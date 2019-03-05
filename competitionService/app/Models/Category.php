<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version February 26, 2019, 9:12 pm UTC
 *
 * @property \App\Models\Competition competition
 * @property \App\Models\DanceGenre danceGenre
 * @property integer competition_id
 * @property string description
 * @property integer dance_genre_id
 * @property integer number_of_team_members
 * @property integer number_of_max_teams
 * @property string fee_currency
 * @property float fee_amount
 */
class Category extends Model
{
    use SoftDeletes;

    public $table = 'category';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'category_id';

    public $fillable = [
        'competition_id',
        'description',
        'dance_genre_id',
        'number_of_team_members',
        'number_of_max_teams',
        'fee_currency',
        'fee_amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'competition_id' => 'integer',
        'description' => 'string',
        'dance_genre_id' => 'integer',
        'number_of_team_members' => 'integer',
        'number_of_max_teams' => 'integer',
        'fee_currency' => 'string',
        'fee_amount' => 'float'
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
        return $this->belongsTo(\App\Models\Competition::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function danceGenre()
    {
        return $this->belongsTo(\App\Models\DanceGenre::class);
    }

    public static function deleteEnvolvedRecords($category_id)
    {
        $djs = Dj::all()->where('category_id', '=', $category_id);
        foreach ($djs as $dj) {
            $dj->delete();
        }
        $mcs = Mc::all()->where('category_id', '=', $category_id);
        foreach ($mcs as $mc) {
            $mc->delete();
        }
        $judges = Judge::all()->where('category_id', '=', $category_id);
        foreach ($judges as $judge) {
            $judge->delete();
        }
        $prizes = Prize::all()->where('category_id', '=', $category_id);
        foreach ($prizes as $prize) {
            $prize->delete();
        }
        $teams = Team::all()->where('category_id', '=', $category_id);
        foreach ($teams as $team) {
            $members = TeamMember::all()->where('team_id', '=', $team->team_id);
            foreach ($members as $member) {
                $member->delete();
            }
            $team->delete();
        }
    }

    public static function findById($category_id)
    {
        $category = \DB::table('category')->where('category_id', '=', $category_id)->get();
        $category = (array)$category[0];
        $mcs = \DB::table('mc')->where('category_id', '=', $category_id)->get();
        $category['mcs'] = $mcs;
        $djs = \DB::table('dj')->where('category_id', '=', $category_id)->get();
        $category['djs'] = $djs;
        $judges = \DB::table('judge')->where('category_id', '=', $category_id)->get();
        $category['judges'] = $judges;
        $teams = \DB::table('team')->where('category_id', '=', $category_id)->get();
        $team_tmp = [];
        foreach ($teams as $team) {
            $team = (array)$team;
            $teamMembers = \DB::table('team_member')->where('team_id', '=', $team['team_id'])->select('member_name')->get();
            $array_member=[];
            foreach ($teamMembers as $teamMember) {
                array_push($array_member,$teamMember->member_name) ;
            }
            $team['members'] = $array_member;
            $team['name'] = $team['team_name'];
            unset($team['team_name']);
            array_push($team_tmp, $team);
        }
//        dd(\DB::table('dance_genre')->where('dance_genre_id','=',$category['dance_genre_id'])->get()[0]->dance_genre_name);
        $category['dance_genre'] = \DB::table('dance_genre')->where('dance_genre_id', '=', $category['dance_genre_id'])->get()[0]->dance_genre_name;
        $category['teams'] = $team_tmp;
        unset($category['dance_genre_id']);
        return $category;
    }
}
