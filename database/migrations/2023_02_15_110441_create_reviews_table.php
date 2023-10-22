<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('organization_id')->nullable();
            $table->string('organization_guid')->nullable();
            $table->text('organization_gmaps_id')->nullable();
            $table->string('review_id')->nullable();
            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_email')->nullable();
            $table->string('reviewer_reviews_count')->nullable();
            $table->string('review_date')->nullable();
            $table->string('review_specified_date')->nullable();
            $table->string('review_rate_stars')->nullable();
            $table->text('review_text_original')->nullable();
            $table->text('review_photos_files')->nullable();
            $table->string('review_thumbs_up_value')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
