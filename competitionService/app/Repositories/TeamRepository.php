<?php

namespace App\Repositories;

use App\Models\Team;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TeamRepository
 * @package App\Repositories
 * @version February 28, 2019, 12:49 pm UTC
 *
 * @method Team findWithoutFail($id, $columns = ['*'])
 * @method Team find($id, $columns = ['*'])
 * @method Team first($columns = ['*'])
*/
class TeamRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'team_name',
        'user_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Team::class;
    }
}
