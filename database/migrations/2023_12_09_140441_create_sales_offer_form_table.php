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
            $table->text('payment_term')->nullable();
            $table->text('payment_term_description')->nullable();
            $table->text('packing')->nullable();
            $table->text('packing_more_details')->nullable();
            $table->text('packing_other')->nullable();
            $table->text('marking_more_details')->nullable();
            $table->text('picture_packing')->nullable();
            $table->text('picture_packing_file')->nullable();
            $table->text('possible_buyers')->nullable();
            $table->text('cost_per_unit')->nullable();
            $table->text('origin_country')->nullable();
            $table->text('origin_port_city')->nullable();
            $table->text('origin_more_details')->nullable();
            //
            $table->text('has_loading')->nullable();
            $table->text('loading_type')->nullable();
            $table->text('loading_country')->nullable();
            $table->text('loading_port_city')->nullable();
            $table->date('loading_from')->nullable();
            $table->date('loading_to')->nullable();
            $table->text('bulk_loading_rate')->nullable();
            $table->text('bulk_shipping_term')->nullable();
            $table->text('container_type')->nullable();
            $table->text('container_thc_included')->nullable();
            $table->text('flexi_tank_country_type')->nullable();
            $table->text('flexi_tank_country_thc_included')->nullable();
            $table->text('loading_more_details')->nullable();
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
