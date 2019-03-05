<?php

namespace App\Repositories;

use App\Models\Prize;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PrizeRepository
 * @package App\Repositories
 * @version February 26, 2019, 9:13 pm UTC
 *
 * @method Prize findWithoutFail($id, $columns = ['*'])
 * @method Prize find($id, $columns = ['*'])
 * @method Prize first($columns = ['*'])
*/
class PrizeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'title',
        'reward'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Prize::class;
    }
}
