<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

/**
 * Class Competition
 * @package App\Models
 * @version February 26, 2019, 9:00 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection category
 * @property \Illuminate\Database\Eloquent\Collection Dj
 * @property \Illuminate\Database\Eloquent\Collection Judge
 * @property \Illuminate\Database\Eloquent\Collection Mc
 * @property \Illuminate\Database\Eloquent\Collection Prize
 * @property \Illuminate\Database\Eloquent\Collection Team
 * @property string competition_name
 * @property integer host_id
 * @property string competition_description
 * @property string background_picture
 * @property date start_date
 * @property time start_time
 * @property date end_date
 * @property time end_time
 * @property string time_zone
 * @property string address_name
 * @property string address_city
 * @property string address_state
 * @property string address_country
 * @property float address_longitude
 * @property float address_latitude
 */
class Competition extends Model
{
    use SoftDeletes;

    public $table = 'competition';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    protected $primaryKey = 'competition_id';

    public $fillable = [
        'competition_name',
        'host_id',
        'competition_description',
        'background_picture',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'time_zone',
        'address_name',
        'address_city',
        'address_state',
        'address_country',
        'address_longitude',
        'address_latitude'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'competition_id' => 'integer',
        'competition_name' => 'string',
        'host_id' => 'integer',
        'competition_description' => 'string',
        'background_picture' => 'string',
        'start_date' => 'date|Y-m-d',
        'end_date' => 'date|Y-m-d',
        'time_zone' => 'string',
        'address_name' => 'string',
        'address_city' => 'string',
        'address_state' => 'string',
        'address_country' => 'string',
        'address_longitude' => 'float',
        'address_latitude' => 'float'
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
    public function danceGenres()
    {
        return $this->belongsToMany(\App\Models\DanceGenre::class, 'category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function djs()
    {
        return $this->hasMany(\App\Models\Dj::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function judges()
    {
        return $this->hasMany(\App\Models\Judge::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function mcs()
    {
        return $this->hasMany(\App\Models\Mc::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function prizes()
    {
        return $this->hasMany(\App\Models\Prize::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function teams()
    {
        return $this->hasMany(\App\Models\Team::class);
    }

    public static function filterCompetition($input, $client, $competitionRepository)
    {
        $validation = Validator::make($input, [
            'page' => 'required|integer|min:0',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        $category = \DB::table('category')->rightJoin('competition', 'category.competition_id', '=', 'competition.competition_id');
        $category = $category->whereNull('category.deleted_at');
        if (isset($input['address_longitude']) && $input['address_longitude'] != null && isset($input['address_latitude']) && $input['address_latitude'] != null) {

            if (isset($input['address_city']) || isset($input['address_country'])) {
                if ($input['address_city'] != null || $input['address_country'] != null)
                    return abort(400, 'Bad Request');
            }
            $category = $category->select(\DB::raw('3959 * acos( cos( radians(' . $input['address_latitude'] . ') ) 
                * cos( radians( address_latitude ) ) * cos( radians( address_longitude ) - radians(' . $input['address_longitude'] . ') ) 
                + sin( radians(' . $input['address_latitude'] . ') ) * sin( radians( address_latitude ) ) ) as distance, competition.competition_id'))->distinct('competition.competition_id');
        }
        if (isset($input['name']) && $input['name'] != null) {

            $validation = Validator::make($input, [
                'name' => 'string',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $category = $category
                ->where('competition_name', 'like', '%' . $input['name'] . '%');
        }

        if (isset($input['dance_genre']) && $input['dance_genre'] != null) {
            $validation = Validator::make($input, [
                'dance_genre' => 'danceGenre',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $input['dance_genre_id'] = \DB::table('dance_genre')->where('dance_genre_name', '=', $input['dance_genre'])->first()->dance_genre_id;
            $category = $category->where('dance_genre_id', '=', $input['dance_genre_id']);
        }

        if (isset($input['number_of_team_members']) && $input['number_of_team_members'] != null) {
            $validation = Validator::make($input, [
                'number_of_team_members' => 'integer',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $category = $category
                ->where('number_of_team_members','=', [$input['number_of_team_members']);
        }

        if (isset($input['address_city']) && $input['address_city'] != null) {
            $validation = Validator::make($input, [
                'address_city' => 'string',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $category = $category
                ->where('address_city', 'like', '%' . $input['address_city'] . '%');
        }

        if (isset($input['address_country']) && $input['address_country'] != null) {
            $validation = Validator::make($input, [
                'address_country' => 'string',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }

            $category = $category
                ->where('address_country', 'like', '%' . $input['address_country'] . '%');
        }

        if (isset($input['from_date']) && $input['from_date'] != null && isset($input['to_date']) && $input['to_date'] != null) {
            $validation = Validator::make($input, [
                'from_date' => ['regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/', 'exist_with:' . $input['to_date']],
                'to_date' => ['regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/', 'greater:' . $input['from_date'], 'exist_with:' . $input['from_date']],
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $from_date = date($input['from_date']);
            $end_date = date($input['to_date']);

            $category = $category->whereBetween('start_date', [$from_date, $end_date]);
        }

        if ((isset($input['from_date']) && $input['from_date'] != null) && !(isset($input['to_date']) && $input['to_date'] != null)) {
            return abort(400, 'Bad Request');
        }

        if ((isset($input['address_longitude']) && $input['address_longitude'] != null) && !(isset($input['address_latitude']) && $input['address_latitude'] != null)) {
            return abort(400, 'Bad Request');
        }

        if (!(isset($input['address_longitude']) && $input['address_longitude'] != null) && (isset($input['address_latitude']) && $input['address_latitude'] != null)) {
            return abort(400, 'Bad Request');
        }


        if (isset($input['user_host_id']) && $input['user_host_id'] != null) {

            $validation = Validator::make($input, [
                'user_host_id' => 'integer',
            ]);

            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $category = $category->where('host_id', '=', $input['user_host_id']);

        }

        if (isset($input['register_host_id']) && $input['register_host_id'] != null) {

            $validation = Validator::make($input, [
                'user_host_id' => 'integer',
            ]);

            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }

            $team_registered = \DB::table('team')->where('user_id', '=', $input['register_host_id'])
                ->whereNull('deleted_at')->get();
            $registerd_array = [];
            foreach ($team_registered as $t) {
                array_push($registerd_array, $t->category_id);
            }
            $category = $category->whereIn('category_id', $registerd_array);
        }

        if (isset($input['address_longitude']) && $input['address_longitude'] != null && isset($input['address_latitude']) && $input['address_latitude'] != null) {
            $category = $category->orderBy('distance');
        }
        $category=$category->whereNull('competition.deleted_at')->distinct('category.competition_id')->get();
        $competitions = [];
        foreach ($category as $cat) {
            $comp = Competition::findById($cat->competition_id, $competitionRepository);
            array_push($competitions, $comp);
        }

        $my_time = Carbon::now()->subDay()->format('Y-m-d');
        foreach ($competitions as $key => $competition) {
            if (date($my_time) > $competition['start_date']) {
                array_push($competitions, $competition);
                unset($competitions[$key]);
            }
        }
        $competitions = array_unique($competitions);
        return array_slice($competitions, ($input['page'] - 1) * 10, 10);
    }

    public static function findById($id, $competitionRepository)
    {
        $competition = $competitionRepository->findWithoutFail($id);
        if (empty($competition)) {
            return abort(404, 'Resource Not Found');
        }

        $categories = \DB::table('category')->where('competition_id', '=', $competition->competition_id)
            ->select('category_id')->whereNull('deleted_at')->get();
        $categories_tmp = [];
        foreach ($categories as $category) {
            $category = Category::findById($category->category_id);
            array_push($categories_tmp, $category);
        }
        $competition['category'] = $categories_tmp;
        $competition['description'] = $competition['competition_description'];
        $competition['name'] = $competition['competition_name'];
        unset($competition['competition_name']);
        unset($competition['competition_description']);
        $competition['address'] = ['name' => $competition['address_name'], 'city' => $competition['address_city'], 'country' => $competition['address_country'], 'state' => $competition['address_state'],
            'geo' => ['longitude' => $competition['address_longitude'], 'latitude' => $competition['address_latitude']]];
        unset($competition['address_name']);
        unset($competition['address_city']);
        unset($competition['address_country']);
        unset($competition['address_state']);
        unset($competition['address_longitude']);
        unset($competition['address_latitude']);
        return $competition;
    }
}
