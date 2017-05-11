@extends('admin::layouts.index')
@section('content')
    <section class="content">
        <div class="error-page">
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> <a href="{{ $url }}"> {{ $message }}</a></h3>
            </div>
        </div>
    </section>
@endsection