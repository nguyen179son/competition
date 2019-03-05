<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use App\Repositories\TeamMemberRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TeamMemberController extends AppBaseController
{
    /** @var  TeamMemberRepository */
    private $teamMemberRepository;

    public function __construct(TeamMemberRepository $teamMemberRepo)
    {
        $this->teamMemberRepository = $teamMemberRepo;
    }

    /**
     * Display a listing of the TeamMember.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->teamMemberRepository->pushCriteria(new RequestCriteria($request));
        $teamMembers = $this->teamMemberRepository->all();

        return view('team_members.index')
            ->with('teamMembers', $teamMembers);
    }

    /**
     * Show the form for creating a new TeamMember.
     *
     * @return Response
     */
    public function create()
    {
        return view('team_members.create');
    }

    /**
     * Store a newly created TeamMember in storage.
     *
     * @param CreateTeamMemberRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamMemberRequest $request)
    {
        $input = $request->all();

        $teamMember = $this->teamMemberRepository->create($input);

        Flash::success('Team Member saved successfully.');

        return redirect(route('teamMembers.index'));
    }

    /**
     * Display the specified TeamMember.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $teamMember = $this->teamMemberRepository->findWithoutFail($id);

        if (empty($teamMember)) {
            Flash::error('Team Member not found');

            return redirect(route('teamMembers.index'));
        }

        return view('team_members.show')->with('teamMember', $teamMember);
    }

    /**
     * Show the form for editing the specified TeamMember.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $teamMember = $this->teamMemberRepository->findWithoutFail($id);

        if (empty($teamMember)) {
            Flash::error('Team Member not found');

            return redirect(route('teamMembers.index'));
        }

        return view('team_members.edit')->with('teamMember', $teamMember);
    }

    /**
     * Update the specified TeamMember in storage.
     *
     * @param  int              $id
     * @param UpdateTeamMemberRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamMemberRequest $request)
    {
        $teamMember = $this->teamMemberRepository->findWithoutFail($id);

        if (empty($teamMember)) {
            Flash::error('Team Member not found');

            return redirect(route('teamMembers.index'));
        }

        $teamMember = $this->teamMemberRepository->update($request->all(), $id);

        Flash::success('Team Member updated successfully.');

        return redirect(route('teamMembers.index'));
    }

    /**
     * Remove the specified TeamMember from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $teamMember = $this->teamMemberRepository->findWithoutFail($id);

        if (empty($teamMember)) {
            Flash::error('Team Member not found');

            return redirect(route('teamMembers.index'));
        }

        $this->teamMemberRepository->delete($id);

        Flash::success('Team Member deleted successfully.');

        return redirect(route('teamMembers.index'));
    }
}
