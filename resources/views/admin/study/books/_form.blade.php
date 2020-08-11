        <h4 class="h5 font-weight-bold">Book info</h4>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="form-group col-5">
                <label for="title">Book name</label>
                {!!
                   Form::text(
                       'title',
                       null,
                       ['class' => 'form-control book-title', 'placeholder' => 'Title', 'id' => 'tilte', 'required']
                   )
                !!}
                @error('title')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
            <div class="form-group col-5">
                <label for="author">Author</label>
                {!!
                   Form::text(
                       'author',
                       null,
                       ['class' => 'form-control book-author', 'placeholder' => 'Author', 'required']
                   )
                !!}
                @error('author')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
            <div class="form-group col-2">
                <label for="edition">Edition</label>
                {!!
                   Form::text(
                       'edition',
                       null,
                       ['class' => 'form-control book-edition', 'placeholder' => 'Edition']
                   )
                !!}
                @error('edition')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="isbn">ISBN</label>
                {!!
                   Form::text(
                       'isbn',
                       null,
                       ['class' => 'form-control book-isbn', 'placeholder' => 'Isbn', 'required']
                   )
                !!}
                <p class="form-text text-muted mb-0">
                    Can either be isbn10, or isbn13. Symbols that aren't numbers or "x" will be ignored.
                </p>
                @error('isbn')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
            <div class="form-group col-3">
                <label for="price">Price in euros</label>
                {!!
                   Form::number(
                       'price',
                       $book->price,
                       ['class' => 'form-control book-price', 'placeholder' => 'Price', 'id' => 'price', 'required']
                   )
                !!}
                <p class='form-text text-muted mb-0'>
                    Must be in whole euros
                </p>
                @error('price')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <label for="description">Description</label>
                {!!
                   Form::text(
                       'description',
                       null,
                       ['class' => 'form-control book-description']
                   )
                !!}
                <p class='form-text text-muted'>
                    Add an (optional) description of the book, i.e. "It contains coffee marks.""
                </p>
                @error('description')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
        </div>
    </div>

            <div class="col-md-3">
                <img alt="" src="{{ $book->cover_path }}" class="book-image" />
            </div>


    <div class="col-md-6"">
        <h4 class="h6 font-weight-bold">
            Seller information
        </h4>
        <p class="form-text text-muted">
            Fill out these forms once the book has been bought by a member
        </p>

        <div class="form-row">
            <div class="col-6">
                <x-forms-autocomplete-member
                    name="seller"
                    name-id="seller_id"
                    label="Sold by"
                    :value="optional($book->seller)->fullname"
                    :value-id="optional($book->seller)->id"
                />
            </div>
            <div class="form-group col-6">
                <label for="purchase_date">Purchase date</label>
                {!!
                   Form::date(
                       'purchase_date',
                       optional($book->taken_in_from_seller_at)->format('Y-m-d'),
                       ['class' => 'form-control', 'id' => 'purchase_date']
                   )
                !!}
                @error('purchase_date')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6"">
        <h4 class="h6 font-weight-bold">
            Buyer information
        </h4>
        <p class="form-text text-muted">
            Fill out these forms once the book has been bought by a member
        </p>
        <div class="form-row">
            <div class="col-6">
                <x-forms-autocomplete-member
                    name="buyer"
                    name-id="buyer_id"
                    label="Bought by"
                    :value="optional($book->buyer)->fullname"
                    :value-id="optional($book->buyer)->id"
                />
            </div>
            <div class="form-group col-6">
                <label for="sale_date">Sale date</label>
                {!!
                   Form::date(
                       'sale_date',
                       optional($book->taken_in_by_buyer_at)->format('Y-m-d'),
                       ['class' => 'form-control', 'id' => 'sale_date']
                   )
                !!}
                @error('sale_date')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
        </div>

        <div class="form-group form-check">
            {!!
               Form::checkbox(
                   'sold',
                   true,
                   $book->has_been_sold,
                   ['class' => 'form-check-input', 'id' => 'sold']
               )
            !!}
            <label class="form-check-label" for="sold">Has been sold</label>
            <p class="form-text text-muted">
                If the buyer of this book is not a member, use this checkmark instead.
            </p>

            @error('sold')
            <p class="invalid-feedback">
                {{ $message  }}
            </p>
            @enderror
        </div>
    </div>


    <div class="col-md-6"">
        <h4 class="h6 font-weight-bold">
            Finance administration
        </h4>
        <p class="form-text text-muted"">
            Check off this checkmark once the book has been paid and processed.
        </p>
        <div class="form-group form-check">
            {!!
               Form::checkbox(
                   'paid_off',
                   true,
                   $book->paid_off, ['class' => 'form-check-input', 'id' => 'paid_off']
               )
            !!}
            <label class="form-check-label" for="paid_off">Has been payed off</label>
            @error('paid_off')
            <p class="invalid-feedback">
                {{ $message  }}
            </p>
            @enderror
        </div>
    </div>
</div>
