<?php

namespace App\Repositories;

use App\Models\Judge;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class JudgeRepository
 * @package App\Repositories
 * @version February 28, 2019, 4:55 pm UTC
 *
 * @method Judge findWithoutFail($id, $columns = ['*'])
 * @method Judge find($id, $columns = ['*'])
 * @method Judge first($columns = ['*'])
*/
class JudgeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'judge_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Judge::class;
    }
}
