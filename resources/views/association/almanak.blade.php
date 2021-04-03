@extends('pages.association')

@push('styles')
    <style type="text/css">
        #almanak{
            width:100vmin;
            height:71vmin;
            position:absolute;
            margin-left: auto ;
            margin-right: auto ;
        }
        #almanak .turn-page{
            background-color:#fafafa;
            background-size:100% 100%;
        }
    </style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="https://old.professorfrancken.nl/almanak/turn.min.js"></script>
@endpush

@section('main-content')
    <div class="container">
        <h1 class="section-header section-header--centered">
            Almanak
        </h1>

        <div class="row">
            <div class="col-md-12">
                <div id="almanak">
                    @foreach ($pages as $page)
                        <div style="background-image:url('{{ $page }}');"></div>
                    @endforeach
                </div>
                <div class="mt-5 d-flex justify-content-between">
                    <button class="btn btn-primary" id="previous">Previous page</button>
                    <a href="{{ $download }}" class="btn btn-text text-primary">Download the pdf</a>
                    <button class="btn btn-primary" id="next">Next page</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script type="text/javascript">
        $(window).ready(function() {
            $('#almanak').turn({
                autoCenter: true,
                acceleration: true,
                elevation:50,
                gradients: !$.isTouch,
            });
        });
        $(window).bind('keydown', function(e){
            if (e.keyCode==37) {
                $('#almanak').turn('previous');
                return false;
            }
            else if (e.keyCode==39) {
                $('#almanak').turn('next');
                return false;
            }
        });

        $("#previous").click(function(e){
            $('#almanak').turn('previous');
            return false;
        });

        $("#next").click(function(e){
            $('#almanak').turn('next');
            return false;
        });
    </script>
    @endpush
