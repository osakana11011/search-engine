<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawlings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url', 2100);
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->dateTime('crawled_at')->nullable();
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
        Schema::dropIfExists('crawlings');
    }
}
