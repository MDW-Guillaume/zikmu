<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('follow')->default(0);
            $table->string('cover')->nullable();
            $table->unsignedBigInteger('style_id')->nullable();
            $table->timestamps();

            $table->foreign('style_id')
                    ->references('id')
                    ->on('styles')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            // $table->foreign('id')
            //         ->references('artist_id')
            //         ->on('artist_user')
            //         ->onUpdate('restrict')
            //         ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
    }
};
