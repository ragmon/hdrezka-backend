<?php

namespace App\Jobs;

use App\Models\SearchRequest;
use App\Services\HDRezka;
use App\Services\SearchRequestParser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SearchJob extends Job
{
    private $searchRequest;

    /**
     * Create a new job instance.
     *
     * @param SearchRequest $searchRequest
     */
    public function __construct(SearchRequest $searchRequest)
    {
        $this->searchRequest = $searchRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $response = HDRezka::getSearchResult($this->searchRequest->query);
            if ($response->status() != Response::HTTP_OK) {
                Log::debug("Ошибка получения данных с hdrezka. Статус код: #" . $response->status());
                throw new \Exception('Ошибка получения результатов поиска с hdrezka');
            }
            $payload = SearchRequestParser::parse($response->body());
            $this->searchRequest->payload = $payload;
            $this->searchRequest->status = SearchRequest::STATUS_DONE;
        } catch (\Exception $e) {
            Log::debug("Ошибка парсера: " . $e->getMessage());
            $this->searchRequest->status = SearchRequest::STATUS_ERROR;
        } finally {
            $this->searchRequest->save();
        }
    }
}
