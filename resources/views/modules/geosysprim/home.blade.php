@extends('layouts.geolocation')

@section('content')
    <main>
        <div id="map" style="width:100%; height: 600px; z-index: -1000"></div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/geosysprim.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
@endsection
