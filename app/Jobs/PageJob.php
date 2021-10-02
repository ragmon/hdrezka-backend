<?php

namespace App\Jobs;

use App\Models\PageRequest;
use App\Services\HDRezka;
use App\Services\PageRequestParser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PageJob extends Job
{
    private $pageRequest;

    /**
     * Create a new job instance.
     *
     * @param PageRequest $pageRequest
     */
    public function __construct(PageRequest $pageRequest)
    {
        $this->pageRequest = $pageRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $response = HDRezka::getVideoPage($this->pageRequest->url);
            if ($response->status() != Response::HTTP_OK) {
                Log::debug("Ошибка получения данных с hdrezka. Статус код: #" . $response->status());
                throw new \Exception('Ошибка получения результатов поиска с hdrezka');
            }
            $payload = PageRequestParser::parse($response->body());
            $this->pageRequest->payload = $payload;
            $this->pageRequest->status = PageRequest::STATUS_DONE;
        } catch (\Exception $e) {
            Log::debug("Ошибка парсера: " . $e->getMessage());
            $this->pageRequest->status = PageRequest::STATUS_ERROR;
        } finally {
            $this->pageRequest->save();
        }
    }
}
