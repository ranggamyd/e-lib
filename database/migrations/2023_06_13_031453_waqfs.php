<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Waqfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waqfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->date('waqf_date');
            $table->string('title');
            $table->longText('soft_file');
            $table->integer('page_count');
            $table->longText('abstract');
            $table->longText('payment_slip');
            $table->enum('status', ['Tertunda', 'Dikonfirmasi', 'Ditolak'])->default('Tertunda');
            $table->text('description')->nullable();
            $table->foreignId('librarian_id')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'librarian_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waqfs');
    }
}
