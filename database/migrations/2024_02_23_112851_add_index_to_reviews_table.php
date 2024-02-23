<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('organization_gmaps_id');
            $table->index('review_id');
            $table->index('reviewer_name');
            $table->index('reviewer_reviews_count');
            $table->index('review_date');
            $table->index('review_rate_stars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('reviews_organization_gmaps_id_index');
            $table->dropIndex('reviews_review_id_index');
            $table->dropIndex('reviews_reviewer_name_index');
            $table->dropIndex('reviews_reviewer_reviews_count_index');
            $table->dropIndex('reviews_review_date_index');
            $table->dropIndex('reviews_review_rate_stars_index');
        });
    }
}
