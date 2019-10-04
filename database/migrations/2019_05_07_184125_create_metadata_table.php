<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->nullable();
            $table->string('model')->nullable();

            $table->unique(['object_id','model']);
            $table->timestamps();
        });

        Schema::create('metadata_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('metadata_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->unique(['metadata_id','locale']);
            $table->foreign('metadata_id')->references('id')->on('metadata')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_translations');
        Schema::dropIfExists('metadata');
    }
}
