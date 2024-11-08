<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->string('old_number');
            $table->string('new_number');
            $table->string('reason');
            $table->string('login_id')->nullable();
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
        Schema::dropIfExists('number_change_requests');
    }
}
