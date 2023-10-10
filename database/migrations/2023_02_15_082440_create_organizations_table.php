<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('slug')->nullable();
            $table->text('gmaps_link')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('price_policy')->nullable(); //new
            $table->string('located_in')->nullable(); //new
            $table->string('organization_gmaps_id')->nullable();
            $table->string('rate_stars')->nullable();
            $table->string('reviews_total_count')->nullable();
            $table->text('organization_category')->nullable();
            $table->string('organization_address')->nullable();
            $table->string('organization_website')->nullable();
            $table->text('organization_phone_number')->nullable();
            $table->string('organization_plus_code')->nullable();
            $table->text('organization_work_time')->nullable();
            $table->text('popular_load_times')->nullable();
            $table->string('organization_latitude')->nullable();
            $table->string('organization_longitude')->nullable();
            $table->text('organization_short_description')->nullable();
            $table->text('organization_head_photo_file')->nullable();
            $table->text('organization_photos_files')->nullable();
            $table->text('organization_email')->nullable();
            $table->text('organization_facebook')->nullable();
            $table->text('organization_instagram')->nullable();
            $table->text('organization_twitter')->nullable();
            $table->text('organization_linkedin')->nullable();
            $table->text('organization_youTube')->nullable();
            $table->text('organization_yelp')->nullable();
            $table->text('organization_trip_advisor')->nullable();
            $table->string('organization_search_request')->nullable();
            $table->text('embed_map_code')->nullable();
            $table->text('organization_skype')->nullable();
            $table->string('organization_telegram')->nullable();
            $table->string('organization_phone_from_the_website')->nullable();
            $table->string('organization_guid')->nullable();
            $table->string('organization_tiktok')->nullable();
            $table->boolean('is_claimed')->default(0);
            $table->string('claimed_mail')->nullable();
            $table->bigInteger('user_id')->default(1);
            $table->bigInteger('views')->unsigned()->default(0)->index();
            $table->string('search_position_number_overall')->nullable(); //new
            $table->boolean('temporarily_closed')->default(0)->comment('0=open,1=closed');
            $table->boolean('permanently_closed')->default(0)->comment('0=open,1=closed');
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
        Schema::dropIfExists('organizations');
    }
}
