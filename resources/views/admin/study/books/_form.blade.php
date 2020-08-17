        <h4 class="h5 font-weight-bold">Book info</h4>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-5">
                <x-forms.text name="title" label="Book name" placeholder="Title" required />
            </div>
            <div class="col-5">
                <x-forms.text name="author" label="Author" placeholder="Author" required />
            </div>
            <div class="col-2">
                <x-forms.text name="edition" label="Edition" placeholder="Edition" />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-forms.text name="isbn" label="ISBN" placeholder="ISBN" required>
                    <x-slot name="help">
                        Can either be isbn10, or isbn13. Symbols that aren't numbers or "x" will be ignored.
                    </x-slot>
                </x-forms.text>
            </div>
            <div class="col-3">
                <x-forms.number name="price" label="Price in euros" placeholder="10" required>
                    <x-slot name="help">
                        Must be in whole euros (so 10 for &euro;10,-)
                    </x-slot>
                </x-forms.number>
            </div>
        </div>
        <x-forms.text name="description" label="Description">
            <x-slot name="help">
                Add an (optional) description of the book, i.e. "It contains coffee marks.""
            </x-slot>
        </x-forms.text>
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
            <div class="col-6">
                <x-forms.date
                    name="purchase_date"
                    label="Purchase date"
                    :value="optional($book->taken_in_from_seller_at)->format('Y-m-d')"
                />
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
            <div class="col-6">
                <x-forms.date
                    name="sale_date"
                    label="Sale date"
                    :value="optional($book->taken_in_by_buyer_at)->format('Y-m-d')"
                />
            </div>
        </div>

        <x-forms.checkbox name="sold" label="Has been sold" :value="$book->has_been_sold">
            <x-slot name="help">
                If the buyer of this book is not a member, use this checkmark instead.
            </x-slot>
        </x-forms.checkbox>
    </div>


    <div class="col-md-6"">
        <h4 class="h6 font-weight-bold">
            Finance administration
        </h4>

        <x-forms.checkbox name="paid_off" label="Has been paid off" :value="$book->paid_off">
            <x-slot name="help">
                Check off this checkmark once the book has been paid and processed.
            </x-slot>
        </x-forms.checkbox>
    </div>
</div>
