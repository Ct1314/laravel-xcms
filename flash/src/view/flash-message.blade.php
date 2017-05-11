@if($errors)
    @foreach($errors->all() as $error)
@section('js')
    <script>
        var error = {!! json_encode($error) !!}
        toastr.error(error);
        error = null;
    </script>
@stop
@endforeach
@endif