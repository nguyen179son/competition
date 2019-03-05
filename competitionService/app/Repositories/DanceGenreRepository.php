<?php

namespace App\Repositories;

use App\Models\DanceGenre;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DanceGenreRepository
 * @package App\Repositories
 * @version February 28, 2019, 12:10 pm UTC
 *
 * @method DanceGenre findWithoutFail($id, $columns = ['*'])
 * @method DanceGenre find($id, $columns = ['*'])
 * @method DanceGenre first($columns = ['*'])
*/
class DanceGenreRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dance_genre_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DanceGenre::class;
    }
}
