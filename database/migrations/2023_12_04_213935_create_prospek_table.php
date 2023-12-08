<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospek', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('userid');
            $table->bigInteger('leadsid');
            $table->tinyInteger('view');
            $table->tinyInteger('favorite');
            $table->text('note')->nullable();
            $table->tinyInteger('lost');
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
        Schema::dropIfExists('prospek');
    }
}
