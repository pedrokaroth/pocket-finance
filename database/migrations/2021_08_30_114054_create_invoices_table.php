<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('wallet_id');
            $table->integer('category_id');
            $table->integer('invoice_of')->nullable();
            $table->string('description');
            $table->text('comments')->nullable();
            $table->double('value', 10, 2);
            $table->string('type');
            $table->date('due_at');
            $table->string('repeat_when');
            $table->integer('enrollments')->nullable();
            $table->integer('enrollment_of')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('invoices');
    }
}
