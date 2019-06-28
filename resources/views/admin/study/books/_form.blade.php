<div class="row mt-4">
    <div class="col-md-3">
        <h4>Book info</h4>
        <div class="form-group">
            <label for="title">Book title</label>
            {!! Form::text('title', null, ['class' => 'form-control book-title', 'placeholder' => 'Title', 'id' => 'tilte']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('edition', null, ['class' => 'form-control book-edition', 'placeholder' => 'Edition']) !!}

        </div>
        <div class="form-group">
            {!! Form::text('author', null, ['class' => 'form-control book-author', 'placeholder' => 'Author']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('description', null, ['class' => 'form-control book-description', 'placeholder' => 'Add an (optional) description of the book, i.e. "It contains coffee marks.""']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('isbn', null, ['class' => 'form-control book-isbn', 'placeholder' => 'Isbn']) !!}
        </div>
        <div class="form-group">
            <label for="price">Price in euros</label>
            {!! Form::number('price', $book->price, ['class' => 'form-control book-price', 'placeholder' => 'Price', 'id' => 'price']) !!}
        </div>
    </div>

    <div class="col-md-3"">
        <h4>Seller</h4>

        <div class="form-group">
            <label for="seller">Sold by</label>
            {!! Form::text('seller', optional($book->seller)->fullName, ['class' => 'form-control book-seller', 'placeholder' => 'Seller', 'id' => 'seller']) !!}
            {!! Form::hidden('seller_id', optional($book->seller)->id, ['class' => 'book-seller-id']) !!}
            <label for="purchase_date">Purchase date</label>
            {!! Form::date('purchase_date', optional($book->purchase_date)->format('Y-m-d'), ['class' => 'form-control', 'id' => 'purchase_date']) !!}
        </div>
    </div>

    <div class="col-md-3"">
        <h4>Buyer</h4>
        <div class="form-group">
            <label for="seller">Bought by</label>
            {!! Form::text('buyer', optional($book->buyer)->fullName, ['class' => 'form-control book-buyer', 'placeholder' => 'Buyer', 'id' => 'buyer']) !!}
            {!! Form::hidden('buyer_id', optional($book->buyer)->id, ['class' => 'book-buyer-id']) !!}
            <label for="sale_date">Sale date</label>
            {!! Form::date('sale_date', optional($book->sale_date)->format('Y-m-d'), ['class' => 'form-control', 'id' => 'sale_date']) !!}
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('sold', true, $book->sold, ['class' => 'form-check-input', 'id' => 'sold'])  !!}
            <label class="form-check-label" for="sold">Has been sold</label>
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('paid_off', true, $book->paid_off, ['class' => 'form-check-input', 'id' => 'paid_off'])  !!}
            <label class="form-check-label" for="paid_off">Has been payed off</label>
        </div>

    </div>

    <div class="col-md-3">
        <img alt="" src="{{ $book->cover_path }}" class="book-image" />
    </div>
</div>

@push('scripts')
<script type="text/javascript">
 $(document).ready(function () {
     var members = {!! json_encode($members) !!};
     var membersSource = members.map(function (member) {
         return {
             label: [member.voornaam, member.tussenvoegsel, member.achternaam].filter(function (val) { return val }).join(' '),
             id: member.id
         };
     });

     $('.book-seller').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             $('.book-seller-id').val(ui.item.id);
         },
         minLength: 2
     });

     $('.book-buyer').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             $('.book-buyer-id').val(ui.item.id);
         },
         minLength: 2
     });
 });
</script>
@endpush
