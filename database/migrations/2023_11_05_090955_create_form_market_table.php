<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_market', function (Blueprint $table) {
            //reza-dev
            $table->id();
            $table->string('company_name');
            $table->tinyInt('company_type');
            $table->string('product_name');
            $table->string('product_type');
            $table->string('product_grade');
            $table->string('product_has_code');
            $table->string('product_cas_no');
            $table->text('product_description_more_details');
            $table->string('benchmark_file');
            $table->string('has_quality_analysis');
            $table->string('quality_analysis_file');

            $table->foreignId('unit');
            $table->foreign('unit')->references('id')->on('units')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('currency');
            $table->foreign('currency')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('target_quantity_amount');
            $table->integer('target_quantity_tolerance');

            $table->string('sellers_or_buyers_option');
            $table->integer('min_quantity');
            $table->integer('max_quantity');
            $table->boolean('has_min_max_quantity');
            $table->boolean('has_different_price');
            $table->boolean('has_partial_shipment');
            $table->string('shipment_number');
            $table->text('shipment_description');
            $table->string('intercoms_version');
            $table->string('incoterms');

            $table->foreignId('incoterm_currency');
            $table->foreign('incoterm_currency')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');

            $table->string('incoterm_port');
            $table->string('price_type');
            $table->integer('target_quantity');
            $table->integer('target_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_market');
    }
};
