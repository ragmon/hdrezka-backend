<?php

namespace App\Http\Controllers;

use App\Jobs\SearchJob;
use App\Models\SearchRequest;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Запрос на поиск
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function query(Request $request)
    {
        $this->validate($request, [
            'query' => 'required|min:1',
        ]);
        /** @var SearchRequest $searchRequest */
        $searchRequest = SearchRequest::create($request->all());
        dispatch(new SearchJob($searchRequest));
        if (env('QUEUE_CONNECTION') == 'sync') {
            $searchRequest->refresh();
        }
        return response()->json($searchRequest->toArray());
    }

    /**
     * Получение результата поиска
     *
     * @param $requestId
     * @return \Illuminate\Http\JsonResponse
     */
    public function result(int $requestId)
    {
        /** @var SearchRequest $searchRequest */
        $searchRequest = SearchRequest::findOrFail($requestId);
        return response()->json($searchRequest->toArray());
    }
}
