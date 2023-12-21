@if(isset($form->status) and $form->is_complete==1)
    @if($form->status==0)
        <button type="button" class="btn btn-sm btn-primary" onclick="changeFormStatus(1,{{ $form->id }})">
            Submit
            <i class="fa fa-check"></i>
        </button>
    @endif
    @if($form->status==1)
        <button type="button" class="btn btn-sm btn-danger" onclick="changeFormStatus(2,{{ $form->id }})">
            Reject
            <i class="fa fa-times"></i>
        </button>
        <button type="button" class="btn btn-sm btn-info" onclick="changeFormStatus(3,{{ $form->id }})">
            Approved
            <i class="fa fa-times"></i>
        </button>
    @endif
    @if($form->status==3)
        <button type="button" class="btn btn-sm btn-warning" onclick="changeFormStatus(4,{{ $form->id }})">
            Show In Commodity
        </button>
    @endif
@endif
