<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePrizeRequest;
use App\Http\Requests\UpdatePrizeRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Repositories\PrizeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;

class PrizeController extends AppBaseController
{
    /** @var  PrizeRepository */
    private $prizeRepository;
    private $competitionRepository;
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepo, CompetitionRepository $competitionRepo, PrizeRepository $prizeRepo)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepo;
        $this->prizeRepository = $prizeRepo;
    }


    /**
     * Store a newly created Prize in storage.
     *
     * @param CreatePrizeRequest $request
     *
     * @return Response
     */
    public function store($competition_id, $category_id, CreatePrizeRequest $request)
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
            'title' => 'required|string',
            'reward' => 'required|string',
	    'user_id' =>'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['prize_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;
        $prize = $this->prizeRepository->create($input);
        return response()->json(['prize_id'=>$prize->prize_id], 200);
    }


    /**
     * Update the specified Prize in storage.
     *
     * @param  int $id
     * @param UpdatePrizeRequest $request
     *
     * @return Response
     */
    public function update($competition_id, $category_id, $prize_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $prize = $this->prizeRepository->findWithoutFail($prize_id);
        if (empty($competition) || empty($category) || empty($prize)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'title' => 'required|string',
            'reward' => 'required|string',
	    'user_id' =>'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['prize_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;

        $prize = $this->prizeRepository->update($input, $prize_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }

    /**
     * Remove the specified Prize from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($competition_id, $category_id, $prize_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $prize = $this->prizeRepository->findWithoutFail($prize_id);
        if (empty($competition) || empty($category) || empty($prize)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
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

        $this->prizeRepository->delete($prize_id);


        return \Illuminate\Support\Facades\Response::make("",200);
    }
}
