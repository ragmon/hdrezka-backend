<?php

namespace App\Http\Controllers;

use App\Jobs\PageJob;
use App\Models\PageRequest;
use Illuminate\Http\Request;

class PageController extends Controller
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
            'search_request_id' => 'required|exists:search_requests,id',
            'url' => 'required|url',
            'type' => 'required|in:' . implode(',', PageRequest::TYPES),
        ]);
        /** @var PageRequest $page */
        $page = PageRequest::create($request->all());
        dispatch(new PageJob($page));
        if (env('QUEUE_CONNECTION') == 'sync') {
            $page->refresh();
        }
        return response()->json($page->toArray());
    }

    /**
     * Получение результата поиска
     *
     * @param $pageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function result(int $pageId)
    {
        /** @var PageRequest $page */
        $page = PageRequest::findOrFail($pageId);
        return response()->json($page->toArray());
    }
}
