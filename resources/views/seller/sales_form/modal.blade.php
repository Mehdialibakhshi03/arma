<!-- Modal -->
<div class="modal fade" id="NeedToSubmitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                   <h3>
                       Preview Sales Form Offer
                   </h3>

            </div>
            <div id="modal_body" class="modal-body p-5 row">

            </div>
            <div class="modal-footer">
                <input id="modal_form_id" type="hidden" value="">
                <button type="button" class="btn btn-primary" data-dismiss="modal">I Need To More Edit</button>
                <button onclick="Final_Submit()" type="button" class="btn btn-success">Final Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="show_modal_form_exists" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="get" action="" class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body p-5">
                Do You Want To Use Previous Sales Form To Fill New Form?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Use Previous Form</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
            <input type="hidden" name="previous_form" id="previous_form">
        </form>
    </div>
</div>
