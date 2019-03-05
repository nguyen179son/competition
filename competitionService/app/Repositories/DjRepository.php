<?php

namespace App\Repositories;

use App\Models\Dj;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DjRepository
 * @package App\Repositories
 * @version February 26, 2019, 9:13 pm UTC
 *
 * @method Dj findWithoutFail($id, $columns = ['*'])
 * @method Dj find($id, $columns = ['*'])
 * @method Dj first($columns = ['*'])
*/
class DjRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'dj_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Dj::class;
    }
}
