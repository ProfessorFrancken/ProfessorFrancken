@extends('admin.layout')
@section('page-title', 'Books')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs card-header-tabs m-0">
                        @component('admin.study.books._tab-navigation', ['request' => $request, 'select' => 'available'])
                        Available books
                            @if ($available_books > 0)
                                <span class="badge badge-secondary text-white">
                                    {{ $available_books }}
                                </span>
                            @endif
                        @endcomponent
                        @component('admin.study.books._tab-navigation', ['request' => $request, 'select' => 'sold'])
                            Sold books
                            @if ($sold_books > 0)
                                <span class="badge badge-danger text-white">
                                {{ $sold_books }}
                                </span>
                            @endif
                        @endcomponent
                        @component('admin.study.books._tab-navigation', ['request' => $request, 'select' => 'paid-off'])
                        Paid off books
                            @if ($paid_off_books > 0)
                                <span class="badge badge-secondary text-white">
                                {{ $paid_off_books }}
                                </span>
                            @endif
                        @endcomponent
                        @component('admin.study.books._tab-navigation', ['request' => $request, 'select' => 'all'])
                        All books
                            @if ($all_books > 0)
                                <span class="badge badge-secondary text-white">
                                {{ $all_books }}
                                </span>
                            @endif
                        @endcomponent
                    </ul>
                </div>

                <div class="card-body">
                    <p>
                        @if ($request->selected('available'))
                            <strong>Available books</strong>: Books shown on the <a href="{{ action([\Francken\Study\BooksSale\Http\BooksController::class, 'index']) }}">books page</a>.
                        @endif
                        @if ($request->selected('sold'))
                            <strong>Sold books</strong>: books that have been sold and are no longer available for purchase by members, these need to be processed by the treasurer.
                        @endif
                        @if ($request->selected('paid-off'))
                            <strong>Paid off books</strong>: books that have been sold and processed by the treasurer.
                        @endif
                        @if ($request->selected('all'))
                            <strong>All books</strong>: all books in our database, use for administration.
                        @endif
                    </p>
                    <form action="{{ action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'index']) }}"
                          method="GET"
                          class="form"
                    >
                        {!! Form::hidden('select', $request->input('select', 'available'))  !!}
                        <div class="d-flex mb-3">
                            <div class="form-group mr-2 mb-0">
                                {!! Form::text('title', $request->title(), ['placeholder' => 'Search by title', 'class' => 'form-control'])  !!}
                            </div>
                            <div class="form-group mx-2 mb-0">
                                {!! Form::text('seller', optional($request->seller())->fullname, ['placeholder' => 'Search by seller', 'class' => 'form-control book-seller', 'id' => 'seller'])  !!}
                                {!! Form::hidden('seller_id', $request->sellerId(), ['class' => 'book-seller-id']) !!}
                            </div>
                            <div class="form-group mx-2 mb-0">
                                {!! Form::text('buyer', optional($request->buyer())->fullname, ['placeholder' => 'Search by buyer', 'class' => 'form-control book-buyer', 'id' => 'buyer'])  !!}
                                {!! Form::hidden('buyer_id', $request->buyerId(), ['class' => 'book-buyer-id']) !!}
                            </div>
                            <button type="submit" class="mx-2 btn btn-sm btn-primary">
                                <i class="fas fa-search"></i>
                                Apply filters
                            </button>
                            <a href="{{ action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'index'])  }}"
                               class="btn btn-sm btn-text text-primary d-flex align-items-center"
                            >
                                <i class="fas fa-times"></i>
                                Clear filters
                            </a>
                        </div>
                    </form>
                </div>
                @include('admin.study.books._table', ['books' => $books])
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
@endpush

@push('scripts')
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 var members = {!! json_encode($members) !!};

 // from https://www.librarieshacked.org/tutorials/autocompletewithapi
 $(document).ready(function () {

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

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'create']) }}"
           class='btn btn-primary'
        >
            <i class="fas fa-plus"></i>
            Add a book
        </a>
    </div>
@endsection
