<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Returns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->foreignId('book_id');
            $table->date('borrow_date');
            $table->date('due_date');
            $table->date('return_date');
            $table->enum('status', ['Dipinjam', 'Dikembalikan']);
            $table->bigInteger('charges');
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
        Schema::dropIfExists('returns');
    }
}
