@extends('layouts.geolocation')

@section('content')
    <main>
<<<<<<< HEAD
        <div id="map" style="width:100%; height: 600px; margin-top:2px"></div>
=======
        <div id="map" style="width:100%; height: 600px;"></div>
>>>>>>> 5b309cd6fee068e870a42fe76c0bab0368e57b8f
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/geosysprim.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
@endsection
