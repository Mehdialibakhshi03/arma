<div class="form-check">
    <input class="form-check-input" type="radio" value="1" id="CheckTermCondition_{{ $market->id }}" name="term_condition">
    <label class="form-check-label" for="flexCheckDefault">
        <strong>
            I Read and accept Bid Instruction and General terms and conditions
        </strong>
    </label>
</div>
<div class="bid_term_condition p-3 text-justify text-white mt-3">
    {!! $term_conditions !!}
</div>
