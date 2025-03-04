<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexOnOrganizationCategoryToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->index(['rate_stars'], 'organizations_rate_stars_index');
            $table->index(['reviews_total_count'], 'organizations_reviews_total_count_index');
            $table->index(['permanently_closed'], 'organizations_permanently_closed_index');
        });

        DB::statement('ALTER TABLE organizations ADD INDEX organizations_organization_category_index (organization_category(191))');
        DB::statement('ALTER TABLE organizations ADD INDEX organizations_organization_category_slug_index (organization_category_slug(191))');
        DB::statement('ALTER TABLE organizations ADD INDEX organizations_organization_address_index (organization_address(191))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropIndex('organizations_organization_category_index');
            $table->dropIndex('organizations_organization_category_slug_index');
            $table->dropIndex('organizations_rate_stars_index');
            $table->dropIndex('organizations_reviews_total_count_index');
            $table->dropIndex('organizations_organization_address_index');
            $table->dropIndex('organizations_permanently_closed_index');
        });

        // Drop indexes for TEXT columns
        DB::statement('ALTER TABLE organizations DROP INDEX organizations_organization_category_index');
        DB::statement('ALTER TABLE organizations DROP INDEX organizations_organization_category_slug_index');
        DB::statement('ALTER TABLE organizations DROP INDEX organizations_organization_address_index');
    }
}
