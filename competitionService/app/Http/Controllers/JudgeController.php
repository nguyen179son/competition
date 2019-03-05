<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJudgeRequest;
use App\Http\Requests\UpdateJudgeRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Repositories\JudgeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;
class JudgeController extends AppBaseController
{
    /** @var  JudgeRepository */
    private $judgeRepository;
    private $competitionRepository;
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo, CompetitionRepository $competitionRepo, JudgeRepository $judgeRepo)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepo;
        $this->judgeRepository = $judgeRepo;
    }

    public function store($competition_id, $category_id, Request $request)
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
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['judge_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;
        $judge = $this->judgeRepository->create($input);
        return response()->json(['judge_id'=>$judge->judge_id], 200);
    }


    /**
     * Update the specified Judge in storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($competition_id, $category_id, $judge_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $judge = $this->judgeRepository->findWithoutFail($judge_id);
        if (empty($competition) || empty($category) || empty($judge)) {
            return abort(404, 'resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }
        $input = $request->all();
        $validation = Validator::make($input, [
            'name' => 'required|string',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $input['judge_name'] = $input['name'];
        $input['category_id'] = (int)$category_id;

        $judge = $this->judgeRepository->update($input, $judge_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }

    /**
     * Remove the specified Judge from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($competition_id, $category_id, $judge_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        $judge = $this->judgeRepository->findWithoutFail($judge_id);

        if (empty($competition) || empty($category) || empty($judge)) {
            return abort(404, 'resource not found');
        }

        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }

        $input = $request->all();

        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $this->judgeRepository->delete($judge_id);

        return \Illuminate\Support\Facades\Response::make("",200);
    }
}
