{!! Form::model($item, [
    'route' => ['admin.header2.update', $item->id],
    'method' => 'Put',
    'data-validate',
    'enctype' => 'multipart/form-data',
]) !!}

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <label class="col-form-label" for="title">Title</label>
            <input id="title" type="text" name="title" class="form-control"
                   placeholder="title" value="{{ $item->title }}">
            @error('title')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-group">
            <label  class="col-form-label" for="number_1">Number 1(min)</label>
            <input id="number_1" type="text" name="number_1" class="form-control"
                   placeholder="Number 1(min)" value="{{ $item->number_1 }}">
            @error('number_1')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-group">
            <label  class="col-form-label" for="number_2">Number 2(max)</label>
            <input id="number_2" type="text" name="number_2" class="form-control"
                   placeholder="Number 2(max)" value="{{ $item->number_2 }}">
            @error('number_2')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-group">
            <label  class="col-form-label" for="number_3">Number 3(percent)</label>
            <input id="number_3" type="text" name="number_3" class="form-control"
                   placeholder="Number 3(percent)" value="{{ $item->number_3 }}">
            @error('number_3')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-group">
            <label  class="col-form-label" for="priority">priority</label>
            <input id="priority" type="text" name="priority" class="form-control"
                   placeholder="priority" value="{{ $item->priority }}">
            @error('priority')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>

    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}


