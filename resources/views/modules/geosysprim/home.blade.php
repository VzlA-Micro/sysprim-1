@extends('layouts.geolocation')

@section('content')
    <main>
        <div id="map" style="width:100%; height: 600px; margin-top:2px"></div>
    
        <div class="row">
          <div class="col s3 center-align hide-on-large-only">
            <a href="{{ route('home') }}" class="btn btn-floating blue tooltipped" data-position="top" data-tooltip="Atras">
              <i class="icon-navigate_before"></i>
            </a>
          </div>
          <div class="col s3 center-align hide-on-large-only">
            <a href="" class="btn btn-floating pink tooltipped" data-position="top" data-tooltip="Pagos Verificados">
              <i class="fa fa-clipboard-list"></i>
            </a>
          </div>
          <div class="col s3 center-align hide-on-large-only">
            <a href="" class="btn btn-floating green tooltipped" data-position="top" data-tooltip="Pagos en Proceso">
              <i class="fa fa-money-check"></i>
            </a>
          </div>
          <div class="col s3 center-align">
            <a href="" id="refresh" class="btn red btn-floating tooltipped" data-position="top" data-tooltip="Refrescar">
              <i class="icon-refresh"></i>
            </a>
          </div>
        </div>
        <!-- <div class="col m6">
        <div class="fixed-action-btn left">
                <a class="btn-floating btn-large red" id="refresh">
                  <i class="icon-refresh"></i>
                </a>
              </div> -->
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/geosysprim.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
@endsection
