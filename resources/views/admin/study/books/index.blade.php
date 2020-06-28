@extends('admin.layout')
@section('page-title', 'Books')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p class="lead">
                        The table below shows only books that are currently being sold.

                    </p>
                    <form action="{{ action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'index']) }}"
                          method="GET"
                          class="form"
                    >
                        <div class="d-flex mb-3">
                            <div class="form-group mr-2 mb-0">
                                {!! Form::text('title', $request->title(), ['placeholder' => 'Search by title', 'class' => 'form-control'])  !!}
                            </div>
                            <div class="form-group mx-2 mb-0">
                                {!! Form::text('seller', optional($request->seller())->full_name, ['placeholder' => 'Search by seller', 'class' => 'form-control book-seller', 'id' => 'seller'])  !!}
                                {!! Form::hidden('seller_id', $request->sellerId(), ['class' => 'book-seller-id']) !!}
                            </div>
                            <div class="form-group mx-2 mb-0">
                                {!! Form::text('buyer', optional($request->buyer())->full_name, ['placeholder' => 'Search by buyer', 'class' => 'form-control book-buyer', 'id' => 'buyer'])  !!}
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
                        <div class="d-flex justify-conten-between">
                            <div class="form-group form-check mx-2">
                                {!! Form::checkbox('show_sold_books', true, $request->showSoldBooks(), ['class' => 'form-check-input', 'id' => 'show_sold_books'])  !!}
                                <label class="form-check-label" for="show_sold_books">Show sold books</label>
                            </div>
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
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'create']) }}"
           class='btn btn-primary'
        >
            <i class="fas fa-plus"></i>
            Add a book
        </a>
    </div>
@endsection
