<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('disabled')->default(false);
            $table->timestamps();

            $table->index('name');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
        Schema::create('fe_group_targets', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->string('target_id', 36);
            $table->string('target_type', 50);
            $table->boolean('disabled')->default(false);
            $table->timestamps();

            $table->unique(['group_id', 'target_id', 'target_type']);
            $table->foreign('group_id')->references('id')->on('fe_groups')->onDelete('cascade');
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
        Schema::dropIfExists('fe_groups');
        Schema::dropIfExists('fe_group_targets');
    }
}
