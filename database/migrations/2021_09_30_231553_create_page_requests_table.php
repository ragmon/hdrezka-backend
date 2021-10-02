<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PageRequest;

class CreatePageRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('search_request_id')->index();
            $table->string('url')->comment('Ссылка на страницу');
            $table->enum('type', PageRequest::TYPES);
            $table->json('payload')->nullable()->comment('Данные собранные со страницы');
            $table->enum('status', PageRequest::STATUSES)->default(PageRequest::STATUS_CREATED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_requests');
    }
}
