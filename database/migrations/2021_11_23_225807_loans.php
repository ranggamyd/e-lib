<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Loans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->foreignId('book_id');
            $table->date('borrow_date')->useCurrent()->useCurrentOnUpdate();
            $table->date('due_date')->useCurrent()->useCurrentOnUpdate();
            $table->enum('status', ['Dipinjam', 'Dikembalikan']);
            $table->foreignId('librarian_id')->nullable();
            $table->timestamps();

            $table->index(['book_id', 'member_id', 'librarian_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
