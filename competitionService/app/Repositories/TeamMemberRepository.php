<?php

namespace App\Repositories;

use App\Models\TeamMember;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TeamMemberRepository
 * @package App\Repositories
 * @version February 26, 2019, 9:14 pm UTC
 *
 * @method TeamMember findWithoutFail($id, $columns = ['*'])
 * @method TeamMember find($id, $columns = ['*'])
 * @method TeamMember first($columns = ['*'])
*/
class TeamMemberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'team_id',
        'member_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TeamMember::class;
    }
}
