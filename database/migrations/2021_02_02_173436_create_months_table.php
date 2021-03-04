<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('months', function (Blueprint $table) {
            $table->id();
            $table->integer('userID');
            $table->decimal('income', 6,1)->default(1000);
            $table->decimal('fixed', 6,1)->default(700);
            $table->decimal('available', 6,1)->virtualAs('income - fixed')->nullable();
            $table->decimal('total_expenses', 6, 1);
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
        Schema::dropIfExists('months');
    }
}
