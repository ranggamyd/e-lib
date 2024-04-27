<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->foreignId('book_id');
            $table->date('order_date')->useCurrent()->useCurrentOnUpdate();
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
