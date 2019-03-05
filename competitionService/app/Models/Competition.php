<?php

namespace App\Models;

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
        $category = \DB::table('category')->leftJoin('competition', 'category.competition_id', '=', 'competition.competition_id');
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
                'dance_genre' => 'string',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $input['dance_genre_id'] = DanceGenre::all()->where('dance_genre_name', '=', $input['dance_genre'])[0]->dance_genre_id;
            $category = $category->whrere('dance_genre_id', '=', $input['dance_genre_id']);
        }

        if (isset($input['number_of_team_members']) && $input['number_of_team_members'] != null) {
            $validation = Validator::make($input, [
                'number_of_team_members' => 'image|mimes:jpeg,jpg,png|max:10000',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $category = $category
                ->whereBetween('number_of_team_members', [$input['number_of_team_members'] - 2, $input['number_of_team_members'] + 2]);
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

        if (isset($input['from_date']) && $input['from_date'] != null && isset($input['end_date']) && $input['end_date'] != null) {
            $validation = Validator::make($input, [
                'from_date' => ['regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/', 'exist_with:' . $input['to_date']],
                'to_date' => ['regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/', 'greater:' . $input['from_date'], 'exist_with:' . $input['from_date']],
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $from_date = date($input['from_date']);
            $end_date = date($input['end_date']);

            $category = $category->whereBetween('start_date', $from_date, $end_date);
        }

        if ((isset($input['address_longitude']) && $input['address_longitude'] != null) && !(isset($input['address_latitude']) && $input['address_latitude'] != null)) {
            return abort(400, 'Bad Request');
        }

        if (!(isset($input['address_longitude']) && $input['address_longitude'] != null) && (isset($input['address_latitude']) && $input['address_latitude'] != null)) {
            return abort(400, 'Bad Request');
        }

        if (isset($input['address_longitude']) && $input['address_longitude'] != null && isset($input['address_latitude']) && $input['address_latitude'] != null) {

            if (isset($input['address_city']) || isset($input['address_country'])) {
                if ($input['address_city'] != null || $input['address_country'] != null)
                    return abort(400, 'Bad Request');
            }

            $validation = Validator::make($input, [
                'address_longitude' => 'address_longitude',
                'address_latitude' => 'address_latitude',
            ]);
            if ($validation->fails()) {
                return abort(400, 'Bad Request');
            }
            $url = 'https://maps.googleapis.com/maps/api/geocode/json';
            $data = [
                'latlng' => '' . $input['address_latitude'] . ',' . $input['address_longitude'],
                'key' => 'AIzaSyC9oQ0zyf49tRgfavHxD6r9fNMvWKBOd_4'
            ];
            $response = $client->post($url, ['query' => $data]);
            $result = json_decode($response->getBody()->getContents());
            if (isset($result->results[0]) && $result->results[0] != null) {
                foreach ($result->results[0]->address_components as $component) {
                    if ($component->types[0] == 'administrative_area_level_1') {
                        $address_city = $component->long_name;
                    }
                    if ($component->types[0] == 'address_country') {
                        $address_country = $component->long_name;
                    }
                }
            } else {
                return abort(400, 'Bad Request');
            }
            $category = $category->where('address_city', 'like', '%' . $address_city . '%')
                ->where('address_country', 'like', '%' . $address_country . '%');
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

            $team_registered = \DB::table('team')->where('user_id', '=', $input['register_host_id'])->whereNull('deleted_at')->get();
            $registerd_array = [];
            foreach ($team_registered as $t) {
                array_push($registerd_array,$t->category_id);
            }
            $category=$category->whereIn('category_id',$registerd_array);
        }

        $category = $category->orderBy('start_date', 'asc')->groupBy('competition.competition_id')->select('competition.competition_id')->get();
        $competitions = [];
        foreach ($category as $cat) {
            $comp = Competition::findById($cat->competition_id, $competitionRepository);
            array_push($competitions, $comp);
        }
        return $competitions;
    }

    public static function findById($id, $competitionRepository)
    {
        $competition = $competitionRepository->findWithoutFail($id);
        if (empty($competition)) {
            return abort(404, 'Resource Not Found');
        }

        $categories = \DB::table('category')->where('competition_id', '=', $competition->competition_id)->select('category_id')->whereNull('deleted_at')->get();
        $categories_tmp = [];
        foreach ($categories as $category) {
            $category = Category::findById($category->category_id);
            array_push($categories_tmp, $category);
        }
        $competition['category'] = $categories_tmp;
        $competition['description'] = $competition['competition_description'];
        $competition['name']=$competition['competition_name'];
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
