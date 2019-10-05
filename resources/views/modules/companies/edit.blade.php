@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12 breadcrumb-nav left-align">
                <a href="{{ route('home') }}" class="breadcrumb">Inicio</a>
                <a href="{{ route('companies.my-business') }}" class="breadcrumb">Mi Empresa</a>
                <a href="{{ route('companies.details', ['id' => $company->id]) }}" class="breadcrumb">{{ $company->name }}</a>
                <a href="" class="breadcrumb">Modificar</a>
            </div>
            <div class="col s12 m8 l6 offset-m2 offset-l3">
                <form action="{{ route('companies.update') }}" method="post" class="card" enctype="multipart/form-data">
                    <div class="card-header center-align">
                        <h5>Editar datos de mi empresa</h5>
                    </div>
                    <div class="card-content row">
                        <div class="input-field col s12 m6">
                            <input type="text" name="name" id="name" value="{{ $company->name }}" required>
                            <label for="name">Nombre</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="RIF" id="RIF" value="{{ $company->RIF }}" required>
                            <label for="RIF">RIF</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="license" id="license" value="{{ $company->license }}" required>
                            <label for="license">Licencia</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" name="opening_date" id="opening_date" class="datepicker" value="{{ $company->opening_date }}" required>
                            <label for="opening_date">Fecha de Apertura</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea name="address" id="" cols="30" rows="10" class="materialize-textarea">{{ $company->address }}</textarea>
                            <label for="address">Dirección</label>
                        </div>
                        <div class="input-field col s12">
                            <span>CIU de la Empresa:</span>
                            <br>
                            <div class="divider"></div>
                            <ul>
                            @foreach($company->ciu as $ciu_selected)
                                <li>{{ $ciu_selected->name }}</li>
                            @endforeach
                            </ul>
                        </div>
                        <div class="input-field col s12">
                            <select multiple name="ciu[]">
                                <option value="null" selected disabled>Seleccionar CIU</option>
                                @foreach($ciu as $ciu):
                                    <option {{-- @if ($company->ciu == $ciu->id) selected @endif --}} value="{{ $ciu->id }}">{{ $ciu->name }}</option>
                                @endforeach
                            </select>
                            <label>Agregar CIU</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn purple">
                                <span><i class="icon-photo_size_select_actual right"></i>Imagen</span>
                                <input type="file" name="image" id="image" value="{{ $company->image }}">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" value="{{ $company->image }}" placeholder="Elige una imagen">
                            </div>
                        </div>
                        <div class="input-field col s12 location-container">
                            <span>Elige tu ubicación:</span>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="btn waves-effect waves-light green">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection