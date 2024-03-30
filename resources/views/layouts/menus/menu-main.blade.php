<ul class="navbar-nav flex-column bg-default mt-2 p-2">
    
    <li class="nav-item"> <a href="#" data-toggle="collapse" data-target="#configuracoes" class="collapsed nav-link"> <i
                class="fa fa-laptop"></i> <span class="nav-label">Configurações</span> <span
                class="fa fa-chevron-left pull-right"></span> </a>
        <ul class="navbar-nav sub-menu collapse p-1" id="configuracoes">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Editar</a></li>
        </ul>
    </li>

    <li class="nav-item"> <a href="#" data-toggle="collapse" data-target="#cadastros-gerais" class="collapsed nav-link">
            <i class="fa fa-edit"></i> <span class="nav-label">Cadastros Gerais</span> <span
                class="fa fa-chevron-left pull-right"></span> </a>
        <ul class="navbar-nav sub-menu collapse  p-1" id="cadastros-gerais">
            <li class="nav-item"><a href="{{ route('centros-custos.index') }}" class="nav-link">Centros de Custos</a></li>
            <li class="nav-item"><a href="{{ route('solicitantes.index') }}" class="nav-link">Solicitantes</a></li>
            <li class="nav-item"><a href="{{ route('empresas.index') }}" class="nav-link">Empresas</a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Frotas</a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Veículos</a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Produtos</a></li>
        </ul>
    </li>

    <li class="nav-item"> <a href="{{ route('home') }}" class="nav-link"><i class="fa fa-laptop"></i> <span
                class="nav-label">Requisições de Compras</span></a></li>
    <li class="nav-item"> <a href="{{ route('home') }}" class="nav-link"><i class="fa fa-laptop"></i> <span
                class="nav-label">Autorizações de Pagamentos</span></a></li>

    <li class="nav-item"> <a href="#" data-toggle="collapse" data-target="#e-commerce" class="collapsed nav-link"><i
                class="fa fa-laptop"></i> <span class="nav-label">Relatórios</span><span
                class="fa fa-chevron-left pull-right"></span></a>
        <ul class="navbar-nav sub-menu collapse p-1" id="e-commerce">
            <li><a href="{{ route('home') }}" class="nav-link">Relatório 1</a></li>
            <li><a href="{{ route('home') }}" class="nav-link">Relatório 2</a></li>
         </ul>
    </li>

    <li class="nav-item"> <a href="#" data-toggle="collapse" data-target="#users" class="collapsed nav-link"><i
                class="fa fa-users"></i> <span class="nav-label">Usuários</span><span
                class="fa fa-chevron-left pull-right"></span></a></li>
    <ul class="navbar-nav sub-menu collapse p-1" id="users">
        <li><a href="{{ route('tipos-usuarios.index') }}" class="nav-link"><span class="fa fa-link mr-1"></span>Tipos</a></li>
        <li><a href="{{ route('user.index') }}" class="nav-link"><span class="fa fa-link mr-1"></span>Usuários</a></li>
    </ul>

</ul>
