<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('collection_id')->nullable();
            $table->string('isbn')->nullable();
            $table->foreignId('publisher_id')->nullable();
            $table->year('publish_year')->nullable();
            $table->foreignId('waqf_id')->nullable();
            $table->longText('image')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('book_pdf')->nullable();
            $table->integer('page_count')->nullable();
            $table->integer('stock')->default(1);
            $table->text('shelf')->nullable();
            // $table->foreignId('librarian_id')->nullable();
            $table->timestamps();

            $table->index(['collection_id', 'publisher_id', 'waqf_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
