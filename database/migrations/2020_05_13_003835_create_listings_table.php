<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('query_id')->unsigned();
            $table->string('listing_id');
            $table->string('title');
            $table->float('price')->unsigned();
            $table->string('condition', 20);
            $table->string('thumbnail');
            $table->string('url');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('query_id')
                ->references('id')
                ->on('queries')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
