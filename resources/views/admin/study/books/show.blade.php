@extends('admin.layout')
@section('page-title', 'Books / ' . $book->title)

@section('content')
    <p>
        When printing the registration form make sure that, when usign Google Chrome, to set the <em>Margins</em> to <em>None</em> and enable <em>Background graphics</em>.
    </p>

    <div class="row">
        <div class="col">
            <div class="card">
                {!! Form::model($book, ['url' => action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'update'], $book->id), 'method' => 'post']) !!}
                <div class="card-body">
                    @method('PUT')

                    @include('admin.study.books._form', ['book' => $book])
                </div>
                <div class="card-footer">
                    {!! Form::submit('Update', ['class' => 'btn btn-outline-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    @if ($book->buyer === null)
        {!! Form::model($book, ['url' => action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'remove'], ['book' => $book]), 'method' => 'post']) !!}
        @method('DELETE')
        <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
                Click <button
                          class="btn btn-text px-1"
                          onclick='return confirm("Are you sure you want to remove this book?");'
                      >here</button> to remove this book.
            </p>
        {!! Form::close() !!}
    @endif
@endsection


@section('actions')
    <div class="d-flex align-items-start">
        <a
            class="btn btn-outline-primary"
            href="{{ action(
                       [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'print'],
                       ['book' => $book]
                   ) }}"
            target="_blank"
        >
            <i class="fas fa-print"></i>
            Print
        </a>
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
 });
</script>
@endpush
