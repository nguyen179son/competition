<?php

namespace App\Http\Controllers;
//require '../../../vendor/autoload.php';

use App\Http\Requests\CreateCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;
use App\Models\Category;
use App\Models\Competition;
use App\Repositories\CategoryRepository;
use App\Repositories\CompetitionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as HttpRequest;

class CompetitionController extends AppBaseController
{
    /** @var  CompetitionRepository */
    private $competitionRepository;
    private $categoryRepository;
    private $client;

    public function __construct(CompetitionRepository $competitionRepo, CategoryRepository $categoryRepository)
    {
        $this->competitionRepository = $competitionRepo;
        $this->categoryRepository = $categoryRepository;
        $this->client = new Client();
    }


    /**
     * Store a newly created Competition in storage.
     *
     * @param CreateCompetitionRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validation = Validator::make($input, [
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'background_picture' => 'required|image|mimes:jpeg,jpg,png|max:10000',
            'start_date' => ['required', 'regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/'],
            'start_time' => ['required', 'regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'],
            'end_date' => ['required', 'regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/', 'greater:' . $input['start_date']],
            'end_time' => ['required', 'regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'],
//            'time_zone' => ['required', 'regex:/[+ | -][0-9]|1[0-1]/'],
            'time_zone' => ['required', 'string'],
            'address_name' => 'required|string',
            'address_city' => 'required|string',
            'address_state' => 'required|string',
            'address_country' => 'required|string',
            'address_longitude' => 'required|longitude',
            'address_latitude' => 'required|latitude',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        $input['host_id']=$input['user_id'];
        $input['competition_name']=$input['name'];
        $input['competition_description']=$input['description'];
        $file = $request->file('background_picture');
        $name = time() . $file->getClientOriginalName();
        $filePath = 'competition/' . $name;
        $file->storeAs(
            'competition', $name, 's3'
        );
        $input['background_picture'] = 's3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $filePath;

        $competition = $this->competitionRepository->create($input);

        return response()->json(['competition_id'=>$competition->competition_id], 200);
    }

    /**
     * Display the specified Competition.
     *
     * @param  int $id
     *
     * @return
     */
    public function show($id)
    {
        $competition = Competition::findById($id,$this->competitionRepository);
        return response()->json($competition, 200);
    }


    /**
     * Update the specified Competition in storage.
     *
     * @param  int $id
     * @param UpdateCompetitionRequest $request
     *
     * @return
     */
    public function update($competition_id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($competition_id);

        if (empty($competition)) {
            return abort(404, 'Resource Not Found');
        }

        $input = $request->all();
        $validation = Validator::make($input, [
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'descriptionóa' => 'required|string',
            'background_picture' => 'required|image|mimes:jpeg,jpg,png|max:10000',
            'start_date' => ['required', 'regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/'],
            'start_time' => ['required', 'regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'],
            'end_date' => ['required', 'regex:/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/', 'greater:' . $input['start_date']],
            'end_time' => ['required', 'regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'],
//            'time_zone' => ['required', 'regex:/[+ | -][0-9]|1[0-1]/'],
            'time_zone' => ['required', 'string'],
            'address_name' => 'required|string',
            'address_city' => 'required|string',
            'address_state' => 'required|string',
            'address_country' => 'required|string',
            'address_longitude' => 'required|longitude',
            'address_latitude' => 'required|latitude',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        $input['host_id']=$input['user_id'];
        $input['competition_name']=$input['name'];
        $input['competition_description']=$input['description'];

        $file = $request->file('background_picture');
        $name = time() . $file->getClientOriginalName();
        $filePath = 'competition/' . $name;
        $file->storeAs(
            'competition', $name, 's3'
        );
        $input['background_picture'] = 's3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $filePath;
        $competition = $this->competitionRepository->create($input);
        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * Remove the specified Competition from storage.
     *
     * @param  int $id
     *
     * @return
     */
    public function destroy($id, Request $request)
    {
        $competition = $this->competitionRepository->findWithoutFail($id);
        $user_id = $request->input('user_id');
        if (empty($competition)) {
            return abort(404, 'resource not found');
        }
        if ($user_id != $competition->host_id) {
            return abort(403, 'Permission denied');
        }


        $categories = Category::all()->where('competition_id', '=', $id);
        foreach ($categories as $category) {
            Category::deleteEnvolvedRecords($category->category_id);
            $this->categoryRepository->delete($category->category_id);
        }
        $this->competitionRepository->delete($id);
        return response()->json([
            'success' => true
        ], 200);
    }

    public function listCompetition(Request $request)
    {
        $input = $request->all();
        $competitions = Competition::filterCompetition($input,$this->client,$this->competitionRepository);
        return $competitions;

    }
}
