@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <div class="row">

            <div class="col s12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                </ul>
            </div>


            @can('Mis Empresas')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('companies.my-business') }}" class="btn-app white blue-text">
                        <i class="icon-work"></i>
                        <span class="truncate">Mis Empresas</span>
                    </a>
                </div>
            @endcan
            @can('Mis Inmuebles')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('properties.my-properties') }}" class="btn-app white grey-text text-darken-2">
                        <i class="icon-location_city"></i>
                        <span class="truncate">Mis Inmuebles</span>
                    </a>
                </div>
            @endcan
            @can('Mis Vehiculos')
                <div>
                    <div class="col s6 m6 l3 animated bounceIn">
                        <a href="{{ route('vehicles.my-vehicles') }}" class="btn-app white red-text text-darken-2">
                            <i class="icon-directions_car"></i>
                            <span class="truncate">Mis Vehículos</span>
                        </a>
                    </div>
                </div>
            @endcan
            @can('Mis Publicidades')
                <div>
                    <div class="col s6 m6 l3 animated bounceIn">
                        <a href="{{ route('publicity.my-publicity') }}" class="btn-app white purple-text text-darken-2">
                            <i class="icon-movie_filter"></i>
                            <span class="truncate">Mis Publicidades</span>
                        </a>
                    </div>
                </div>
            @endcan
            @can('Generar Tasas')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{route('rate.taxpayers.menu')}}" class="btn-app white green-text text-darken-2">
                        <i class="fas fa-clipboard"></i>
                        <span class="truncate">Gestión de  Tasas</span>
                    </a>
                </div>
            @endcan
            @can('Gestionar Usuarios')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('users.manage') }}" class="btn-app white indigo-text text-darken-4">
                        <i class="icon-account_box"></i>
                        <span class="truncate">Gestionar Usuarios</span>
                    </a>
                </div>
            @endcan
            @can('Gestionar Contribuyentes')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('taxpayers.manage') }}" class="btn-app white blue-text text-darken-2">
                        <i class="icon-record_voice_over"></i>
                        <span class="truncate">Gestionar Usuarios Web</span>
                    </a>
                </div>
            @endcan
            @can('Configuración')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('settings.manage') }}" class="btn-app white green-text text-darken-2">
                        <i class="icon-settings"></i>
                        <span class="truncate">Configuración</span>
                    </a>
                </div>
            @endcan
            @can('GeoSEMAT')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('geosysprim') }}" class="btn-app white red-text text-darken-4">
                        <i class="icon-public"></i>
                        <span class="truncate">GeoSEMAT</span>
                    </a>
                </div>
            @endcan
            @can('Estadisticas')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('dashboard') }}" class="btn-app white yellow-text text-darken-4">
                        <i class="icon-multiline_chart"></i>
                        <span class="truncate">Estadísticas</span>
                    </a>
                </div>
            @endcan
            {{--@can('Taquilla - Actividad Económica')
                --}}{{--<div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('home.ticket-office') }}" class="btn-app white pink-text text-darken-4">
                        <i class="icon-personal_video"></i>
                        <span class="truncate">Taquilla - Actividad Económica</span>
                    </a>
                </div>--}}{{--
            @endcan--}}
            @can('Taquillas')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('ticketOffice.home') }}" class="btn-app white amber-text text-darken-1">
                        <i class="icon-personal_video"></i>
                        <span class="truncate">Taquillas</span>
                    </a>
                </div>
            @endcan
            @can('Seguridad')
                <div class="col s6 m6 l3 animated bounceIn">
                    <a href="{{ route('security.manage') }}" class="btn-app white grey-text text-darken-2">
                        <i class="icon-security"></i>
                        <span class="truncate">Seguridad</span>
                    </a>
                </div>
            @endcan



            {{-- @can('Notificaciones')
            <div class="col s6 m6 l3 animated bounceIn">
                <a href="{{ route('notifications.manage') }}" class="btn-app white red-text">
                    <i class="icon-notifications"></i>
                    <span class="truncate">Gestionar Notificaciones</span>
                </a>
            </div>
            @endcan --}}


            <div>
                <!--

                <?php  $key = base64_encode("b836895f28c011e9853800505699c076"); ?>
                <a href="#" id="myCheck"
                   onclick="myFunction('<?php echo "123";?>','<?php echo "0.001"; ?>','<?php echo $key; ?>')">
                    <img title="Realizar el pago por medio de la plataforma Petro Pago"
                         src="https://cdn.petro.gob.ve/petropay/petro.png" width="110px" height="40px">
                </a>
                -->



            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/validations.js') }}"></script>
    <script src="{{ asset('js/dev/ticketOffice.js') }}"></script>
<!--
    <script type="text/javascript">
        // Initialize openpgp
        let openpgp = window.openpgp;
        var openPgpWorkerPath = "http://sysprim.com.devel/js/openpgp.worker.min.js";

        openpgp.initWorker({path: openPgpWorkerPath});

        // put keys in backtick (``) to avoid errors caused by spaces or tabs
        const pubkey = `-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: OpenPGP.js v3.1.3
Comment: https://openpgpjs.org

xsBNBFyUAcUBB/9vGswL314ZWKNls1zY92HtVkV/H28m2FKohUN98tDjPN/U
NxUVZ/sjHT6p4ngtdGgWWM6acmX1132hKSEFiKXUO7CtrIv9e6mEK8I2gefU
J/FYRDZwQYAZLcs7EfmH/k/4dA+ZRbyv1pyylU43cHj3Ut7cFSVUHErGlqat
9hA1J+x5q3DtBMoKC7VVBVsJji2f5n+QlErbEtjEHdYLQjaVE44wmzftv1tF
S/aDhZdixn3gRERiDpqW5vEUt2qwTUg+mZUALwKff7nTfekdHfxsp30FErBM
mTLAhpX/pNPrG8z+/RbNq3E7j8orndsVRVx9BNy317ZFkNZ06zKNgMw9ABEB
AAHNIkVjby1DcnlwdG8gPGVjb2NyeXB0b0BwYnNjb2luLmNvbT7CwHUEEAEI
ACkFAlyUAcUGCwkHCAMCCRAv9NYUTEDvggQVCAoCAxYCAQIZAQIbAwIeAQAA
q8QH/R8hOwRNreUK9RX1/lj2eWbSOwblcEdQHSOPcoH5FFRHsotGmAUZ+EMW
74K8U4UbEcBAzpcvfasnDETJg4UFjtZCcxuwA+Gpr0T0Fd5YfiE78DqHISXr
3+c/BBi0jg1ywK4Zd95HjdYpFi2TqXyXGBUd0qDF1yWdNyEloksLkgqDDHNz
KvTDUtZjFhSFMLGBhF1PVYLS4y9d5qS1gEY9P3/8DvXs6pf/m2lwH6MmB1ql
BWJvWbMIvVdn6l9zvKuTjRDERCCFa/aAOOTQT38TMcg7hZjvR2I+Fw15aTmQ
RBJYqU3kJ4SaDSa94GQY5XdKjlJwW4k6myann9WFah/O5S/OwE0EXJQBxQEH
/38z2P7kM24QKm4a9nK3KtoaeFfXIzibx03ukRWVpaMFaQqHcIXdLyu+Xzj1
MKd63X3EBKQ7pU960F1+izua05HpWsSW/V2fAAJ7ltSALOgP3XruCxGNyzT+
SeuxjFW20jaOeZP1Sw8iF2PMdOJUIY7UYjfuutMXRetU1XAqOg0jg3U7dG+r
0AfRSqL97THaQTUXsuj+PWNUbotXqaVU/HYVSTuSUU+Buc04+ePNfUT7NTlM
yvmrWE7/u8OG9hXk3LTyFGoX8HSSe50/fzu/FrFEdXadurkIkOqfZf/CtEt6
GjVQ3SBpA/jrTAa7ew6485OBkVdXlD0DxjJYF2zP+NEAEQEAAcLAXwQYAQgA
EwUCXJQBxQkQL/TWFExA74ICGwwAADjfB/9tla7/3csC2S2XLAyCzBZYSKMe
SAsJKpB+iyRxO3tHESK0bxxdOsgvi0FT4gAYoBK/q+IfczeBV0tfEtQOcQtA
ryAMwpyj88lxHyrIIKoxx5Qgo0WCKP8q5RaGYUJ6g8XdMlmwIuUYXB9yTeAF
mAbe2luQ+qf2fU4Mld9B8PIGjSqi9UXLqvFxHY4TEUaPPKlhV2wJM+1OV/vB
iFqY6huclcfKNm4eY4K2GzunsIYrEfotGdU0+PUzSu743/NKK3wgjU893P/E
OPq0D0LnEI+shhJOO+TBFOq1PIBeElRY+dp5KUJ8M+dvp7Din/CCsxJMYeO9
Mppqq/qU662Sfo4G
=+wQC
-----END PGP PUBLIC KEY BLOCK-----`;


        const encryptFunction = async (message, publicKey) => {
            var encrypted;

            const options = {
                message: openpgp.message.fromText(message),       // input as Message object
                publicKeys: (await openpgp.key.readArmored(publicKey)).keys, // for encryption
            }

            return openpgp.encrypt(options).then(ciphertext => {
                encrypted = ciphertext.data
                return encrypted
            })
        }

        function b64EncodeUnicode(str) {
            return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function (match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
        }

    </script>

    <script>
        function myFunction(invoice, monto, key) {
            var invoicePago = String(invoice);
            var montoPago = monto;
            var Apikey = atob(key);

            console.log(montoPago);
            var arrayParam = {
                "apikey": Apikey,
                "amount": montoPago,
                "invoice": invoicePago,
                "callback": "www.petroshopvenezuela.com"
            };
            var parametros = JSON.stringify(arrayParam);


            encryptFunction(parametros, pubkey).then(function (value) {
                var pgpParametros = value
                var b64Parametros = b64EncodeUnicode(pgpParametros);
                var url = "https://petropay.petro.gob.ve/signin/?q=" + b64Parametros;
                var windowObjectReference = window.open(url, 'GoogleWindow', 'width=450, height=950')

                return value
            })
            var url = "https://petropay.petro.gob.ve";
            var windowObjectReference = window.open(url, 'GoogleWindow', 'width=450, height=950')
        }
    </script>-->


    <script>
        $(document).ready(function () {
            $('#bank-point').formSelect();
        })
    </script>
@endsection

