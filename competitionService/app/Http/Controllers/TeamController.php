<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\TeamMember;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Repositories\TeamMemberRepository;
use App\Repositories\TeamRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;

class TeamController extends AppBaseController
{
    /** @var  TeamRepository */
    private $teamRepository;
    private $teamMemberRepository;
    private $categoryRepository;
    private $competitionRepository;

    public function __construct(TeamMemberRepository $teamMemberRepository, CategoryRepository $categoryRepo, CompetitionRepository $competitionRepo, TeamRepository $teamRepo)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepo;
        $this->teamRepository = $teamRepo;
        $this->teamMemberRepository = $teamMemberRepository;
    }


    /**
     * Store a newly created Team in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store($competition_id, $category_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        if (empty($competition) || empty($category)) {
            return abort(404, 'resource not found');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
            'members' => 'required|array'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['team_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;

        $team = $this->teamRepository->create($input);
        foreach ($input['members'] as $member) {
            $member = array('team_id' => $team->team_id, 'member_name' => $member);
            $mem = $this->teamMemberRepository->create($member);
        }
        return response()->json(['team_id'=>$team->team_id], 200);
    }


    /**
     * Update the specified Team in storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($competition_id, $category_id, $team_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $team = $this->teamRepository->findWithoutFail($team_id);
        if (empty($competition) || empty($category) || empty($team)) {
            return abort(404, 'resource not found');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
            'members' => 'required|array'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $team->user_id) {
            return abort(403, 'Permission denied');
        }

        $input['team_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;

        $team = $this->teamRepository->update($input, $team_id);
        $team->delete_team_member();
        foreach ($input['members'] as $member) {
            $member = array('team_id' => $team->team_id, 'member_name' => $member);
            $mem = $this->teamMemberRepository->create($member);
        }
        return \Illuminate\Support\Facades\Response::make("",200);
    }

    /**
     * Remove the specified Team from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($competition_id, $category_id, $team_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $team = $this->teamRepository->findWithoutFail($team_id);

        if (empty($competition) || empty($category) || empty($team)) {
            return abort(404, 'resource not found');
        }

        $input = $request->all();
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $team->delete_team_member();
        $this->teamRepository->delete($team_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }
}
