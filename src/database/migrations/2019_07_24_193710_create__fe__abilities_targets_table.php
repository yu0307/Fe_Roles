<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeAbilitiesTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe_abilities_targets', function (Blueprint $table) {
            $table->unsignedBigInteger('ability_id');
            $table->string('target_id',36);
            $table->string('target_type',50);
            $table->boolean('disabled')->default(false);
            $table->timestamps();

            $table->unique(['ability_id', 'target_id', 'target_type']);
            $table->foreign('ability_id')->references('id')->on('fe_abilities')->onDelete('cascade');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fe_abilities_targets');
    }
}
