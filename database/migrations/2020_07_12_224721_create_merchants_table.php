<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('address');
            $table->string('contact_no')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('merchant_locations', function (Blueprint $table) {
            $table->integer('merchant_id')->index();
            $table->integer('location_id');
            $table->integer('updated_by')->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        // Schema::table('merchant_locations', function($table) {
        //    $table->foreign('merchant_id')->references('id')->on('merchants')->onUpdate('cascade');
        // });

        Schema::create('merchant_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('merchant_id')->index();
            $table->string('category_name');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('status');
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
        // Schema::table('merchant_locations', function($table) {
        //     $table->dropForeign('merchant_locations_merchant_id_foreign');
        // });

        Schema::dropIfExists('merchants');
        Schema::dropIfExists('merchant_locations');
        Schema::dropIfExists('merchant_categories');

        
    }
}
