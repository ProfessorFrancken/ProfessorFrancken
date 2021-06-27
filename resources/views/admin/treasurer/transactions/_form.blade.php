<div class="row">
    <div class="col">
        <x-forms-autocomplete-member
            name="member"
            name-id="member_id"
            label="Member"
            :value="optional($transaction->purchasedBy)->fullname"
            :value-id="optional($transaction->purchasedBy)->id"
        />

        <x-forms.select name="product_id" label="Product" :options="$products" />

        <x-forms.datetime name="time" label="Time" :value="optional($transaction->tijd ?? new \DateTimeImmutable)->format('Y-m-d H:i:s')" />


        @if ($transaction->id === null)
            {!! Form::hidden("totaalprijs", $transaction->totaalprijs) !!}
            {!! Form::hidden("amount", $transaction->aantal ?? 1) !!}
        @else
            <x-forms.number
                name="price"
                label="Price"
                :value="$transaction->prijs"
                :readonly="$transaction->id === null"
                help="The transaction price is determined from the product but can be changed manually if needed."
                step="0.01"
            />

            @if ($transaction->prijs !== $transaction->totaalprijs)
                <x-forms.number
                    name="totaalprijs"
                    label="Totaalprijs"
                    :value="$transaction->totaalprijs"
                >
                    <x-slot name="help">
                        <div class="text-danger">
                            The total price of this transaction is not equal to the given price. This may be because this is an old transaction where the system allowed buying more than 1 of the same products in 1 transaction.
                            If you need to change the price of this transaction make sure to change the total price and amount as necessary (i.e. total price = amount * price).
                            Note that only the total price is used for deductions, price and amount can be used for determining consumption statistics.
                        </div>
                    </x-slot>
                </x-forms.number>

            <x-forms.number
                name="amount"
                label="Amount"
                :value="$transaction->aantal"
                help="Amount of products purchased in this transaction."
            />
            @else
                {!! Form::hidden("amount", $transaction->aantal ?? 1) !!}
            @endif
        @endif

    </div>
</div>
