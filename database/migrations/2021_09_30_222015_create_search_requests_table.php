<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SearchRequest;

class CreateSearchRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_requests', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->json('payload')->nullable();
            $table->enum('status', SearchRequest::STATUSES)->default(SearchRequest::STATUS_CREATED);
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
        Schema::dropIfExists('search_requests');
    }
}
