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
            $table->integer('unique_number')->nullable();
            //company
            $table->text('company_name')->nullable();
            $table->text('company_type')->nullable();
            $table->text('unit')->nullable();
            $table->text('unit_other')->nullable();
            $table->text('currency')->nullable();
            $table->text('currency_other')->nullable();
            //product
            $table->text('commodity')->nullable();
            $table->text('type_grade')->nullable();
            $table->text('hs_code')->nullable();
            $table->text('cas_no')->nullable();
            $table->text('product_more_details')->nullable();
            //quantity
            $table->text('max_quantity')->nullable();
            $table->text('min_order')->nullable();
            $table->text('tolerance_weight')->nullable();
            $table->text('tolerance_weight_by')->nullable();
            //quality
            $table->text('specification')->nullable();
            $table->text('specification_file')->nullable();
            $table->text('quality_inspection_report')->nullable();
            $table->text('quality_inspection_report_file')->nullable();
            //incoterms
            $table->text('partial_shipment')->nullable();
            $table->text('partial_shipment_number')->nullable();
            $table->text('increase_quantity')->nullable();
            $table->text('increase_quantity_value')->nullable();
            $table->text('shipment_more_details')->nullable();
            //
            $table->text('incoterms')->nullable();
            $table->text('incoterms_other')->nullable();
            $table->text('incoterms_version')->nullable();
            $table->text('country')->nullable();
            $table->text('port_city')->nullable();
            $table->text('incoterms_more_details')->nullable();
            $table->text('price_type')->nullable();
            $table->text('formulla')->nullable();
            $table->text('price')->nullable();
            //payment term
            $table->text('payment_term')->nullable();
            $table->text('payment_term_description')->nullable();
            $table->text('packing')->nullable();
            $table->text('packing_more_details')->nullable();
            $table->text('packing_other')->nullable();
            //marking
            $table->text('marking_more_details')->nullable();
            $table->text('picture_packing')->nullable();
            $table->text('picture_packing_file')->nullable();
            $table->text('possible_buyers')->nullable();
            $table->text('cost_per_unit')->nullable();
            //origin
            $table->text('origin_country')->nullable();
            $table->text('origin_port_city')->nullable();
            $table->text('origin_more_details')->nullable();
            //loading
            $table->text('has_loading')->nullable();
            $table->text('loading_type')->nullable();
            $table->text('loading_country')->nullable();
            $table->text('loading_port_city')->nullable();
            $table->date('loading_from')->nullable();
            $table->date('loading_to')->nullable();
            $table->text('bulk_loading_rate')->nullable();
            $table->text('loading_bulk_shipping_term')->nullable();
            $table->text('loading_container_type')->nullable();
            $table->text('loading_container_thc_included')->nullable();
            $table->text('loading_flexi_tank_type')->nullable();
            $table->text('loading_flexi_tank_thc_included')->nullable();
            $table->text('loading_more_details')->nullable();
            //discharging
            $table->text('has_discharging')->nullable();
            $table->text('discharging_type')->nullable();
            $table->text('discharging_country')->nullable();
            $table->text('discharging_port_city')->nullable();
            $table->date('discharging_from')->nullable();
            $table->date('discharging_to')->nullable();
            $table->text('bulk_discharging_rate')->nullable();
            $table->text('discharging_bulk_shipping_term')->nullable();
            $table->text('discharging_container_type')->nullable();
            $table->text('discharging_container_thc_included')->nullable();
            $table->text('discharging_flexi_tank_type')->nullable();
            $table->text('discharging_flexi_tank_thc_included')->nullable();
            $table->text('discharging_more_details')->nullable();
            //destination
            $table->text('destination')->nullable();
            $table->text('exclude_market')->nullable();
            $table->text('target_market')->nullable();
            //inspection
            $table->text('quality_quantity_inspection')->nullable();
            $table->text('inspection_place')->nullable();
            $table->text('inspection_more_detail')->nullable();
            //insurance
            $table->text('cargo_insurance')->nullable();
            $table->text('insurance_more_details')->nullable();
            //safety
            $table->text('safety_product')->nullable();
            $table->text('safety_product_file')->nullable();
            //reach certificate
            $table->text('reach_certificate')->nullable();
            $table->text('reach_certificate_file')->nullable();
            //documents
            $table->text('documents_count')->nullable();
            $table->text('documents_options')->nullable();
            $table->text('document_more_detail')->nullable();
            //contact_person
            $table->text('contact_person_name')->nullable();
            $table->text('contact_person_job_title')->nullable();
            $table->text('contact_person_email')->nullable();
            $table->text('pre_code')->nullable();
            $table->text('contact_person_mobile_phone')->nullable();
            $table->text('platform')->nullable();
            //last part
            $table->text('last_more_detail')->nullable();
            $table->text('accept_terms')->nullable();
            //status
            $table->integer('status')->default(0);
            $table->text('has_deposit')->nullable();
            $table->text('deposit_value')->nullable();
            $table->text('data_pending_message')->nullable();
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
