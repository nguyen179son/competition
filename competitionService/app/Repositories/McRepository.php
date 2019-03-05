<?php

namespace App\Repositories;

use App\Models\Mc;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class McRepository
 * @package App\Repositories
 * @version February 26, 2019, 9:13 pm UTC
 *
 * @method Mc findWithoutFail($id, $columns = ['*'])
 * @method Mc find($id, $columns = ['*'])
 * @method Mc first($columns = ['*'])
*/
class McRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'mc_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Mc::class;
    }
}
