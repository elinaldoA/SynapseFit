<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Elinaldo Agostinho">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SynapseFit') }}</title>
    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Synapse <sup>Fit</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ Nav::isRoute('home') }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            @if (Auth::user()->role === 'aluno')
                <!-- Menu para USUÁRIO -->
                <div class="sidebar-heading">
                    {{ __('Minha Conta') }}
                </div>

                <li class="nav-item {{ Nav::isRoute('profile') }}">
                    <a class="nav-link" href="{{ route('profile') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>{{ __('Perfil') }}</span>
                    </a>
                </li>

                <li class="nav-item {{ Nav::isRoute('plano') }}">
                    <a class="nav-link" href="{{ route('planos.upgrade') }}">
                        <i class="fas fa-fw fa-wallet"></i>
                        <span>{{ __('Financeiro') }}</span>
                    </a>
                </li>

                <li class="nav-item {{ Nav::isRoute('alimentacao') }}">
                    <a class="nav-link" href="{{ route('alimentacao') }}">
                        <i class="fas fa-fw fa-utensils"></i>
                        <span>{{ __('Dietas') }}</span>
                    </a>
                </li>

                <li class="nav-item {{ Nav::isRoute('hidratacao') }}">
                    <a class="nav-link" href="{{ route('hidratacao') }}">
                        <i class="fas fa-glass-whiskey"></i>
                        <span>{{ __('Hidratação') }}</span>
                    </a>
                </li>

                <li class="nav-item {{ Nav::isRoute('workouts') }}">
                    <a class="nav-link" href="{{ route('workouts') }}">
                        <i class="fas fa-fw fa-dumbbell"></i>
                        <span>{{ __('Treinos') }}</span>
                    </a>
                </li>

                <li class="nav-item {{ Nav::isRoute('chat') }}">
                    <a class="nav-link" href="{{ route('chat.index') }}">
                        <i class="fas fa-fw fa-message"></i>
                        <span>{{ __('Chat') }}</span>
                    </a>
                </li>
            @elseif(Auth::user()->role === 'admin')
                <!-- Menu para ADMINISTRADOR -->
                <div class="sidebar-heading">
                    {{ __('GESTÃO') }}
                </div>

                <li class="nav-item {{ Nav::isRoute('usuarios') }}">
                    <a class="nav-link" href="{{ route('usuarios') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>{{ __('Usuários') }}</span>
                    </a>
                </li>

                <li class="nav-item {{ Nav::isRoute('admin.financeiro') }}">
                    <a class="nav-link" href="{{ route('financeiro') }}">
                        <i class="fas fa-fw fa-briefcase"></i>
                        <span>{{ __('Financeiro') }}</span>
                    </a>
                </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                @if (auth()->user()->unreadNotifications->count())
                                    <span class="badge badge-danger badge-counter">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="alertsDropdown" style="min-width: 320px;">
                                <h6 class="dropdown-header bg-primary text-white">
                                    <i class="fas fa-bell mr-2"></i> Central de Avisos
                                </h6>

                                <div class="max-h-80 overflow-y-auto px-2">
                                    @forelse (auth()->user()->unreadNotifications as $notification)
                                        <div class="dropdown-item d-flex align-items-start border-bottom py-2">
                                            <div class="mr-2 mt-1">
                                                <i class="fas fa-info-circle text-primary text-sm"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="text-gray-800 text-sm">
                                                    {{ $notification->data['mensagem'] ?? $notification->data['message'] ?? 'Nova notificação' }}
                                                </div>
                                                <small class="text-xs text-gray-500 d-block">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                                <a href="{{ route('notifications.read', $notification->id) }}"
                                                   class="text-xs text-blue-600 hover:underline mt-1 d-inline-block">
                                                    <i class="fas fa-check mr-1"></i>Marcar como lida
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="dropdown-item text-center text-sm text-gray-500">
                                            Nenhuma nova notificação.
                                        </div>
                                    @endforelse
                                </div>

                                @if (auth()->user()->unreadNotifications->count())
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center mb-2">
                                        <a href="{{ route('notifications.read.all') }}"
                                           class="text-xs text-success font-weight-bold hover:underline">
                                            <i class="fas fa-check-double mr-1"></i>Marcar todas como lidas
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <figure class="img-profile rounded-circle avatar font-weight-bold"
                                    data-initial="{{ Auth::user()->name[0] }}"></figure>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    @yield('main-content')
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <a href="#" target="_blank">SynapseFit</a>
                            {{ now()->year }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Pronto para sair?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Logout" abaixo se estiver pronto para encerrar sua sessão atual.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newNotificationModal" tabindex="-1" role="dialog"
        aria-labelledby="newNotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Notificação</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="notification-message">
                    <!-- Mensagem será preenchida via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alertMessages = document.querySelectorAll('.alert');
                alertMessages.forEach(function(alert) {
                    alert.style.display = 'none';
                });
            }, 5000);
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            setInterval(function() {
                window.location.reload(true);
            }, 60000);
        });
    </script>
</body>

</html>
