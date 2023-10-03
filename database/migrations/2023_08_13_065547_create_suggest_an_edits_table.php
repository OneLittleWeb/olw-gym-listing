<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuggestAnEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggest_an_edits', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->boolean('is_it_closed')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('temporarily_closed')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('are_you_the_owner')->default(0)->comment('0: No, 1: Yes');
            $table->string('organization_name')->nullable();
            $table->string('organization_address')->nullable();
            $table->string('organization_phone_number')->nullable();
            $table->string('organization_website')->nullable();
            $table->text('price_list_url')->nullable();
            $table->text('organization_work_time')->nullable();
            $table->text('organization_short_description')->nullable();
            $table->text('message')->nullable();
            $table->integer('edit_status')->default(0)->comment('0: Pending, 1: Approved, 2: Rejected');
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
        Schema::dropIfExists('suggest_an_edits');
    }
}
