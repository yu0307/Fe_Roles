<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeRoleAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe_role_abilities', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('ability_id');
            $table->boolean('disabled')->default(false);
            $table->timestamps();

            $table->unique(['role_id', 'ability_id']);
            $table->foreign('role_id')->references('id')->on('fe_roles')->onDelete('cascade');
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
        Schema::dropIfExists('fe_role_abilities');
    }
}
