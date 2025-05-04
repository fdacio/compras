<ul class="navbar-nav flex-column bg-default mt-2 p-2">

    <li class="nav-item"> <a href="#" data-toggle="collapse" data-target="#requisicoes-compras"
            class="collapsed nav-link">
            <i class="fa fa-file-text"></i> <span class="nav-label">Requisições de Compras</span>
            <span class="fa fa-chevron-left pull-right"></span> </a>
        <ul class="navbar-nav sub-menu collapse p-1" id="requisicoes-compras">

            <li class="nav-item ml-2"> <a href="{{ route('requisicoes-compras.index') }}" class="nav-link"><i
                        class="fa fa-search"></i> <span class="nav-label">Consultar</span></a></li>

            <li class="nav-item ml-2"> <a href="{{ route('requisicoes-compras.create') }}" class="nav-link"><i
                        class="fa fa-search"></i> <span class="nav-label">Cadastrar</span></a></li>
        </ul>
    </li>


</ul>
