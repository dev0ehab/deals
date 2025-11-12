<?php

namespace Modules\FAQs\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\FAQs\Entities\FAQ;
use Modules\FAQs\Repositories\FAQRepository;
use Modules\FAQs\Transformers\QuestionsResource;
use Modules\Support\Traits\ApiTrait;

class FaqsController extends Controller
{
    use ApiTrait;

    private $repository;

    /**
     * CountryController constructor.
     */
    public function __construct(FAQRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the Advertisements.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $questions = $this->repository->all();
        $data = QuestionsResource::collection($questions)->response()->getData(true);
        return $this->sendResponse($data, 'success');
    }


    public function show($id)
    {
        $questions = FAQ::find($id);
        if ($questions) {
            $data = new QuestionsResource($questions);
            return $this->sendResponse($data, __('Data Found'));
        }
        return $this->sendError(__('No data found'), [], 404);
    }
}
