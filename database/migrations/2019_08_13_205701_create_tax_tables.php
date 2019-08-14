<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->smallIncrements('id');
            $table->string('name');
        });
        Schema::create('counties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->smallIncrements('id');
            $table->string('name');
            $table->unsignedSmallInteger('state_id');
            $table->foreign('state_id')
                ->references('id')->on('states')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::create('taxes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->smallIncrements('id');
            $table->string('name');
        });
        Schema::create('taxes_rates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->primary(['tax_id', 'county_id']);
            $table->unsignedSmallInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedSmallInteger('county_id');
            $table->foreign('county_id')
                ->references('id')->on('counties')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('rate');
        });
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->date('date');
            $table->decimal('amount', 19, 2);
            $table->unsignedSmallInteger('county_id');
            $table->foreign('county_id')
                ->references('id')->on('counties')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedSmallInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['date', 'county_id', 'tax_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('taxes_rates');
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('counties');
        Schema::dropIfExists('states');
    }
}
