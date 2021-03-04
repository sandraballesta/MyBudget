<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailable3ColumnToMonths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('months', function (Blueprint $table) {
            $table->decimal('available3', 6,1)->virtualAs('income - fixed - total_expenses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('months', function (Blueprint $table) {
            $table->dropColumn('available3');
        });
    }
}
