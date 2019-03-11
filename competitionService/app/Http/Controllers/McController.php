<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMcRequest;
use App\Http\Requests\UpdateMcRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Repositories\McRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;

class McController extends AppBaseController
{
    /** @var  McRepository */
    private $mcRepository;

    public function __construct(CategoryRepository $categoryRepo, CompetitionRepository $competitionRepo, McRepository $mcRepo)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepo;
        $this->mcRepository = $mcRepo;
    }


    /**
     * Store a newly created Mc in storage.
     *
     * @param CreateMcRequest $request
     *
     * @return Response
     */
    public function store($competition_id, $category_id, CreateMcRequest $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        if (empty($competition) || empty($category)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
	    'user_id' =>'required|string'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['mc_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;
        $mc = $this->mcRepository->create($input);

        return response()->json(['mc_id'=>$mc->mc_id], 200);
    }

    /**
     * Update the specified Mc in storage.
     *
     * @param  int $id
     * @param UpdateMcRequest $request
     *
     * @return Response
     */
    public function update($competition_id, $category_id, $mc_id, UpdateMcRequest $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $mc = $this->mcRepository->findWithoutFail($mc_id);
        if (empty($competition) || empty($category) || empty($mc)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
	    'user_id' =>'required|string'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['mc_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;

        $mc = $this->mcRepository->update($input, $mc_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }

    /**
     * Remove the specified Mc from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($competition_id, $category_id, $mc_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $mc = $this->mcRepository->findWithoutFail($mc_id);

        if (empty($competition) || empty($category) || empty($mc)) {
            return abort(404, 'resource not found');
        }

        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }

        $input = $request->query();
	$validation = Validator::make($input, [
	    'user_id' =>'required|string'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $this->mcRepository->delete($mc_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }
}
