<div class="bid_deposit p-3">
    <h4 class="text-center text-white">Bid Deposit: ${{ $market->bid_deposit }}</h4>
    {!! $bid_deposit_text_area !!}
    <div class="form-check">
        <input class="form-check-input" type="radio" value="Online" id="Online"
               name="payment_type">
        <label class="form-check-label" for="Online">
            Online
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="Wallet" id="Wallet"
               name="payment_type">
        <label class="form-check-label" for="Wallet">
            Wallet
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="Cash" id="Cash" name="payment_type">
        <label class="form-check-label" for="Cash">
            Cash
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="Account" id="Account"
               name="payment_type">
        <label class="form-check-label" for="Account">
            Account
        </label>
    </div>
</div>
