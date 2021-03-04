<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableColumnToMonths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('months', function (Blueprint $table) {
            $table->decimal('available', 6,1)->default(300)->after('fixed');
            $table->decimal('total_expenses', 6, 1)->default(0)->after('available');
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
            $table->dropColumn('available');
            $table->dropColumn('total_expenses');
        });
    }
}
