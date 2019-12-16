@extends('layouts.geolocation')

@section('content')
    <main>
        <div id="map" style="width:100%; height: 600px; margin-top:2px"></div>
    
        <div class="row">
          <div class="col s2 center-align hide-on-large-only">
            <a href="{{ route('home') }}" class="btn btn-floating blue tooltipped" data-position="top" data-tooltip="Atras">
              <i class="icon-arrow_back"></i>
            </a>
          </div>
          <div class="col s2 center-align hide-on-large-only">
            <a href="#" id="company-solvent" class="btn btn-floating pink tooltipped" data-position="top" data-tooltip="Pagos Verificados">
              <i class="fas fa-calendar-check"></i>
            </a>
          </div>
          <div class="col s2 center-align hide-on-large-only">
            <a href="#" id='company-process' class="btn btn-floating green tooltipped" data-position="top" data-tooltip="Pagos en Proceso">
              <i class="fa fa-money-check"></i>
            </a>
          </div>
          <div class="col s2 center-align hide-on-large-only">
            <a href="#" id='company-registered' class="btn indigo btn-floating tooltipped" data-position="top" data-tooltip="Empresas Registradas">
              <i class="fas fa-map-marked"></i>
            </a>
          </div>
          <div class="col s2 center-align  hide-on-large-only">
            <a href="#" id='company-process-verified' class="btn orange btn-floating tooltipped" data-position="top" data-tooltip="Relación Actual">
              <i class="fas fa-map-marked-alt"></i>
            </a>
          </div>
          <div class="col s2 center-align">
            <a href="" id="refresh" class="btn red btn-floating tooltipped" data-position="top" data-tooltip="Refrescar">
              <i class="icon-refresh"></i>
            </a>
          </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/dev/geosysprim.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWMT2X7UmvgCAphCXoD0X4bAr8Isyb7LU&callback=initMap" type="text/javascript"></script>
@endsection
