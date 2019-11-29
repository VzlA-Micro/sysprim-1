@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notifications.read') }}">Notificaciones</a></li>
                </ul>
            </div>
            <div class="col s12 m10 offset-m1">
                <ul class="collection with-header">
                  <li class="collection-header center-align"><h4>Notificaciones</h4></li>
                    <a class="collection-item avatar waves-effect waves-light" href="{{ route('notifications.details') }}">
                        <i class="icon-done circle grey"></i>
                        <span class="title"><b>Title</b></span>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim itaque nostrum deleniti, consequuntur saepe nam expedita mollitia quam commodi debitis.</p>
                        <a href="#!" class="secondary-content"><i class="icon-grade"></i></a>
                    </a>
                    <a class="collection-item avatar waves-effect waves-light" href="{{ route('notifications.details') }}">
                        <i class="icon-done_all circle green"></i>
                        <span class="title"><b>Title</b></span>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim itaque nostrum deleniti, consequuntur saepe nam expedita mollitia quam commodi debitis.</p>
                        <a href="#!" class="secondary-content"><i class="icon-grade"></i></a>
                    </a>
                    <a class="collection-item avatar waves-effect waves-light" href="{{ route('notifications.details') }}">
                        <i class="icon-done circle grey"></i>
                        <span class="title"><b>Title</b></span>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim itaque nostrum deleniti, consequuntur saepe nam expedita mollitia quam commodi debitis.</p>
                        <a href="#!" class="secondary-content"><i class="icon-grade"></i></a>
                    </a>
                    <a class="collection-item avatar waves-effect waves-light" href="{{ route('notifications.details') }}">
                        <i class="icon-done_all circle green"></i>
                        <span class="title"><b>Title</b></span>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim itaque nostrum deleniti, consequuntur saepe nam expedita mollitia quam commodi debitis.</p>
                        <a href="#!" class="secondary-content"><i class="icon-grade"></i></a>
                    </a>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection