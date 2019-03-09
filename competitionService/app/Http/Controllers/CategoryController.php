<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Competition;
use App\Models\DanceGenre;
use App\Models\Dj;
use App\Models\Judge;
use App\Models\Mc;
use App\Models\Team;
use App\Models\TeamMember;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;
    private $competitionRepository;

    public function __construct(CategoryRepository $categoryRepo, CompetitionRepository $competitionRepo)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepo;
    }


    public function show($competition_id, $category_id)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        $category = $this->categoryRepository->findWithoutFail($category_id);
        if (empty($competition) || empty($category)) {
            return abort(404, 'Resource not found');
        }
        if ($category->competition_id != $competition_id) {
            return abort(409, 'Conflict');
        }
        $category = Category::findById($category_id);
        return response()->json([$category],200);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store($competition_id, CreateCategoryRequest $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);
        if (empty($competition)) {
            return abort(404, 'resource not found');
        }
        $input = $request->all();
        $input['competition_id'] = $competition_id;
        $validation = Validator::make($input, [
            'user_id' => 'required|integer',
            'description' => 'required|string',
            'dance_genre' => 'required|danceGenre',
            'number_of_team_members' => 'required|integer|min:1',
            'number_of_max_teams' => 'required|integer|min:1',
            'fee_currency' => 'required|string',
            'fee_amount' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }
        $input['dance_genre_id'] = DanceGenre::all()->where('dance_genre_name', '=', $input['dance_genre'])[0]->dance_genre_id;
        $category = $this->categoryRepository->create($input);
        $returnValue=['category_id'=>$category->category_id];
        return response()->json($returnValue, 200);
    }


    /**
     * Update the specified Category in storage.
     *
     * @param  int $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($competition_id, $category_id, UpdateCategoryRequest $request)
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
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }
        $validation = Validator::make($input, [
            'user_id' => 'required|integer',
            'description' => 'required|string',
            'dance_genre' => 'required|danceGenre',
            'number_of_team_members' => 'required|integer|min:1',
            'number_of_max_teams' => 'required|integer|min:1',
            'fee_currency' => 'required|string',
            'fee_amount' => 'required|numeric',
        ]);

        $category = $this->categoryRepository->update($request->all(), $category_id);

        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($competition_id, $category_id, UpdateCategoryRequest $request)
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
        if ($input['user_id'] != $competition->host_id) {
            return abort(403, 'Permission denied');
        }

        $this->categoryRepository->delete($category_id);

        Category::deleteEnvolvedRecords($category_id);

        return response()->json([
            'success' => true
        ], 200);
    }
}
