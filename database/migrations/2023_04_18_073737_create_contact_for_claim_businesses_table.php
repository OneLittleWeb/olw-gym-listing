<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactForClaimBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_for_claim_businesses', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->string('contact_email');
            $table->string('contact_number')->nullable();
            $table->text('editable_information')->nullable();
            $table->json('validation_images')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('contact_for_claim_businesses');
    }
}
