<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            // Users
            $table->unsignedInteger('user_id')->nullable();
            $table->foreing('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Quotient
            $table->unsignedInteger('quotient_id');
            $table->foreign('quotient_id')
                ->references('id')
                ->on('quotients')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->float('amount');
            $table->string('comment', 1000);

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
        Schema::dropIfExists('payments');
    }
}
