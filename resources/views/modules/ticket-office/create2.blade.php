@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/receipt.css') }}">        
@endsection

@section('content')
    @php setlocale(LC_MONETARY, 'en_US');@endphp
    <div class="container-fluid">
        <div class="row">
            .col.s12
        </div>
    </div>

@endsection

@section('scripts')

@endsection