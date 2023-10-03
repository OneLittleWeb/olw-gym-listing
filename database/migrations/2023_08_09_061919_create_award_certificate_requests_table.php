<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardCertificateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_certificate_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->string('requested_user_name')->nullable();
            $table->string('requested_user_email')->nullable();
            $table->boolean('is_affiliated')->default(0)->comment('0: No, 1: Yes');
            $table->integer('award_status')->default(0)->comment('0: Pending, 1: Approved, 2: Rejected');
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
        Schema::dropIfExists('award_certificate_requests');
    }
}
