<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->index('organization_name', 'organizations_organization_name_index');
            $table->index('category_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('organization_gmaps_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropIndex('organizations_organization_name_index');
            $table->dropIndex('organizations_category_id_index');
            $table->dropIndex('organizations_state_id_index');
            $table->dropIndex('organizations_city_id_index');
            $table->dropIndex('organization_gmaps_id_index');
        });
    }
}
