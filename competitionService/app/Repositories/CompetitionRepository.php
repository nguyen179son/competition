<?php

namespace App\Repositories;

use App\Models\Competition;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CompetitionRepository
 * @package App\Repositories
 * @version February 26, 2019, 9:00 pm UTC
 *
 * @method Competition findWithoutFail($id, $columns = ['*'])
 * @method Competition find($id, $columns = ['*'])
 * @method Competition first($columns = ['*'])
*/
class CompetitionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        'city',
        'state',
        'country',
        'longitude',
        'latitude'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Competition::class;
    }
}
