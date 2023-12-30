<!-- Modal -->
<div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h3>
                    Change Status
                </h3>

            </div>
            <div id="modal_body" class="modal-body p-5 row">
                <h5>
                    select New Status
                </h5>
                <div class="d-flex">
                    <button data-id="4" class="change_status_btn">Reject</button>
                    <button data-id="5" class="change_status_btn">Approved</button>
                    <button data-id="3" class="change_status_btn">Data Pending</button>
                </div>
                <div id="approved_box" class="mb-3 mt-3 status_options d-none">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="safety_product" class="mb-2">Do You want to determine deposit for this ?</label>
                        </div>
                        <div>
                            <div class="form-check form-check-inline mr-3">
                                <input onclick="changeDeposit(this)"
                                       class="form-check-input"
                                       type="radio"
                                       name="deposit"
                                       value="1">
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input onclick="changeDeposit(this)"
                                       class="form-check-input"
                                       type="radio"
                                       name="deposit"
                                       value="0">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>
                    <div id="deposit_input" class="mb-3 mt-3 status_options d-none">
                        <div class="mt-3 mb-3">
                            <label for="deposit" class="form-label">Deposit</label>
                            <input class="form-control" type="number" id="deposit">
                        </div>
                    </div>
                </div>
                <div id="data_pending" class="mb-3 mt-3 status_options d-none">
                    <div class="mt-3 mb-3">
                        <label for="data_pending_message" class="form-label">Message</label>
                        <textarea class="form-control" id="data_pending_message" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <input type="hidden" name="modal_form_id" id="modal_form_id">
            <input type="hidden" name="status_id" id="status_id">
            {{ csrf_field() }}
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success save_btn" onclick="SaveChangeStatus()">
                    <i class="fa fa-recycle"></i>
                    change
                </button>
            </div>
        </div>
    </div>
</div>

