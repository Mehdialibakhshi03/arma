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
        Schema::create('sales_offer_form', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('unique_number');
            $table->text('company_name')->nullable();
            $table->text('company_type')->nullable();
            $table->text('unit')->nullable();
            $table->text('unit_other')->nullable();
            $table->text('currency')->nullable();
            $table->text('currency_other')->nullable();
            $table->text('commodity')->nullable();
            $table->text('type_grade')->nullable();
            $table->text('hs_code')->nullable();
            $table->text('cas_no')->nullable();
            $table->text('product_more_details')->nullable();
            $table->text('specification')->nullable();
            $table->text('specification_file')->nullable();
            $table->text('quality_inspection_report')->nullable();
            $table->text('quality_inspection_report_file')->nullable();
            $table->text('max_quantity')->nullable();
            $table->text('min_order')->nullable();
            $table->text('tolerance_weight')->nullable();
            $table->text('tolerance_weight_by')->nullable();
            $table->text('partial_shipment')->nullable();
            $table->text('partial_shipment_number')->nullable();
            $table->text('shipment_more_detail')->nullable();
            $table->text('incoterms')->nullable();
            $table->text('incoterms_other')->nullable();
            $table->text('incoterms_version')->nullable();
            $table->text('country')->nullable();
            $table->text('port_city')->nullable();
            $table->text('incoterms_more_detail')->nullable();
            $table->text('price_type')->nullable();
            $table->text('formulla')->nullable();
            $table->text('price')->nullable();
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
        Schema::dropIfExists('sales_offer_form');
    }
};
