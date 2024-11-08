<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('from_bank_name')->nullable();
            $table->string('from_bank_accno')->nullable();
            $table->string('to_bank_name')->nullable();
            $table->string('to_bank_accno');
            $table->decimal('amount', 20, 2);
            $table->unsignedInteger('order_id');
            $table->string('attachment')->nullable();
            $table->enum('status', ['Unverified', 'Verified'])->default('Unverified');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
