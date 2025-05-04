<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Compras') }}</title>

    <!-- Styles -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">     
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-dark navbar-expand-sm bg-primary p-0 ">
            <div class="col-md-2 col-lg-2 p-0">
                <div class="d-flex p-0">
                    <a class="navbar-brand pl-1 w-100 mr-0" href="{{ route('home') }}">
                        <img src="{{ asset('img/logo-sistema-compras-navbar.png') }}" alt="logo" width="130">
                    </a>
                    <button class="navbar-toggler hidden-lg-up float-sx-right" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-md-10 col-lg-10 p-0">
                <div class="collapse navbar-collapse">
                    @auth
                        <ul class="nav navbar-nav px-3 ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user-circle mr-2  text-white" style="font-size: 24px"></i>
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('perfil')}}">Perfil</a>
                                    <a class="dropdown-item" href="{{ route('edit.password') }}">Alterar Senha</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Sair</a>
                                </div>

                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="collapse navbar-collapse menu-responsive" id="navbarSupportedContent">
            <nav class="nav navbar-nav text-white bg-primary">
                @if (Auth::user()->tipo->id == 1 || Auth::user()->tipo->id == 2)
                    @include('layouts.menus.menu-main')                            
                @else
                    @include('layouts.menus.menu-operador')
                @endif    
            </nav>
        </div>
    </header>

    <div class="container-fluid body-content">
        <div class="row">
            <nav class="sidebar bg-light col-md-2 col-lg-2">
                <div class="sidebar-sticky">
                    @include('layouts.menus.menu-main')
                </div>
            </nav>
            <main role="main" class="col-md-10 col-lg-10 ml-sm-auto">
                @yield('content')
            </main>
        </div>
    </div>
    <footer>
        Copyright 2021 - 2025. Todos os Direitos Reservados
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        //Rotas para consultas ajax
        var rota = {
            cidades: "{{ route('api.cidades.show', '_estado_') }}",
            cep: "{{ route('api.cep.show', '_cep_') }}",
            cnpj: "{{ route('api.pessoasjuridicas.cnpj', '_cnpj_') }}",
            cpf: "{{ route('api.pessoasfisicas.cpf', '_cpf_') }}",
            empresa: "{{ route('api.empresas.cnpjcpf', '_cnpjcpf_') }}",
            empresas: "{{ route('api.empresas') }}",
            favorecido: "{{ route('api.favorecidos.cnpjcpf', '_cnpjcpf_') }}",
            favorecidos: "{{ route('api.favorecidos') }}",
        }
    </script>

    <script>

        $(function() {

            $('.form').submit(function() {
                $(this).find('button[type=submit]').prop('disabled', true).html('Aguarde...');
            });

            $('.cnpj').mask('99.999.999/9999-99');
            $('.cpf').mask('999.999.999-99');
            $('.cep').mask('99.999-999');
            $('.telefone').mask('(99)9999-9999');
            $('.celular').mask('(99)9 9999-9999');
            $('.ano').mask('9999');

            $.fn.select2.defaults.set('theme', 'bootstrap');
            $.fn.select2.defaults.set('language', 'pt-BR');
            $('.select').select2({
                dropdownAutoWidth: true,
                width: '100%'
            });

            jQuery.datetimepicker.setLocale('pt');
            $(".calendar").datetimepicker({
                format: 'd/m/Y',
                timepicker: false,
                allowBlank: true,
                validateOnBlur: false,
                scrollMonth: false,
                scrollInput: false,
                i18n: {
                    pt: {
                        months: [
                            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ],
                        dayOfWeek: [
                            'D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'
                        ]
                    }
                },
            });

            $('input.data').mask('99/99/9999');

            $('input.real').maskMoney({
                prefix: 'R$ ',
                thousands: '.',
                decimal: ',',
                precision: 2,
                selectAllOnFocus: true,
                allowZero: true
            }).trigger('mask.maskMoney');

            $('input.real-negative').maskMoney({
                prefix: 'R$ ',
                thousands: '.',
                decimal: ',',
                precision: 2,
                selectAllOnFocus: true,
                allowZero: true,
                allowNegative: true
            }).trigger('mask.maskMoney');

            $('input.percentual').maskMoney({
                suffix: ' %',
                thousands: '.',
                decimal: ',',
                precision: 2,
                selectAllOnFocus: true,
                allowZero: true
            }).trigger('mask.maskMoney');

            $('input.quantidade').maskMoney({
                prefix: '',
                thousands: '',
                decimal: ',',
                precision: 0,
                selectAllOnFocus: true,
            }).trigger('mask.maskMoney');

            $('input.decimal').maskMoney({
                prefix: '',
                thousands: '',
                decimal: ',',
                precision: 2,
                selectAllOnFocus: true,
            }).trigger('mask.maskMoney');
            
            $('input.numero, input.codigo, input.item').keyup(function(e) {
                if (/\D/g.test(this.value)) {
                    this.value = this.value.replace(/\D/g, '');
                }
            });

            $('.collapse').on('shown.bs.collapse', function() {
                var item = $(this).parents('.nav-item').find('.fa-chevron-left');
                item.toggleClass('fa-chevron-left fa-chevron-down');
            });

            $('.collapse').on('hidden.bs.collapse', function() {
                var item = $(this).parents('.nav-item').find('.fa-chevron-down');
                item.toggleClass('fa-chevron-down fa-chevron-left');
            });

            $('#btn-toggle-sidebar').on('click', function() {
                $(this).toggleClass('fa fa-arrow-left fa fa-bars')
                $('#contentMain').toggleClass('col-md-10 col-lg-10 col-md-12 col-lg-12');
                $('#menuSidebar').toggle("slow");
            });

        });
    </script>

    @yield('scripts')

</body>

</html>
