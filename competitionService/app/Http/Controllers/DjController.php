<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDjRequest;
use App\Http\Requests\UpdateDjRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Repositories\DjRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;

class DjController extends AppBaseController
{
    /** @var  DjRepository */
    private $djRepository;

    public function __construct(CategoryRepository $categoryRepo, CompetitionRepository $competitionRepo, DjRepository $djRepo)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepo;
        $this->djRepository = $djRepo;
    }


    /**
     * Store a newly created Dj in storage.
     *
     * @param CreateDjRequest $request
     *
     * @return Response
     */
    public function store($competition_id, $category_id, CreateDjRequest $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        if (empty($competition) || empty($category)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(404, 'resource not found');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
	    'user_id' =>'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['dj_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;
        $dj = $this->djRepository->create($input);

        return response()->json(['dj_id' => $dj->dj_id], 200);
    }

    /**
     * Update the specified Dj in storage.
     *
     * @param  int $id
     * @param UpdateDjRequest $request
     *
     * @return Response
     */
    public function update($competition_id, $category_id, $dj_id, UpdateDjRequest $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $dj = $this->djRepository->findWithoutFail($dj_id);
        if (empty($competition) || empty($category) || empty($dj)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id || $dj->category_id != $dj_id) {
            return abort(404, 'resource not found');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
	    'user_id' =>'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['dj_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;

        $dj = $this->djRepository->update($input, $dj_id);

        return \Illuminate\Support\Facades\Response::make("", 200);
    }

    /**
     * Remove the specified Dj from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($competition_id, $category_id, $dj_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $dj = $this->djRepository->findWithoutFail($dj_id);
        if (empty($competition) || empty($category) || empty($dj)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id || $dj->category_id != $dj_id) {
            return abort(404, 'resource not found');
        }
        $input = $request->query();
	$validation = Validator::make($input, [
	    'user_id' =>'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $this->djRepository->delete($dj_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }
}
