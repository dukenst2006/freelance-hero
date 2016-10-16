<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdjustedColumnToWorkSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_sessions', function($table)
        {
            $table->boolean('adjusted')->default(false)->after('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('work_sessions', function ($table) {
        $table->dropColumn(['adjusted']);
    });
    }
}
