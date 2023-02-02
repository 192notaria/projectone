<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="./index.html">
                        <img src="{{ url('v3/src/assets/img/rounded-logo-notaria.svg') }}"  alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="./index.html" class="nav-link"> Notaria 192 </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{activeRoute(route('home'))}}  menu-heading">
                <a href="/dashboard" class="dropdown-toggle">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Inicio</span>
                    </div>
                </a>
            </li>

            <li class="menu {{activeRoute(route('usuarios.guardias'))}} {{activeRoute(route('admin-clientes'))}} {{activeRoute(route('lista-contactos'))}}">
                <a href="#clientesNav" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Agenda</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="clientesNav" data-bs-parent="#accordionExample">
                    <li class="{{activeRoute(route('admin-clientes'))}}">
                        <a href="/administracion/clientes"> Clientes </a>
                    </li>
                    <li class="{{activeRoute(route('lista-contactos'))}}">
                        <a href="/contactos/lista_contactos"> Contactos </a>
                    </li>
                    <li class="{{activeRoute(route('usuarios.guardias'))}}">
                        <a href="/usuarios/guardias"> Guardias </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{activeRoute(route('escrituras-proceso'))}} {{activeRoute(route('escrituras-proceso2'))}} {{activeRoute(route('escrituras-apoyo'))}}">
                <a href="#serviciosNav" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Escrituras</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="serviciosNav" data-bs-parent="#accordionExample">
                    <li class="{{activeRoute(route('escrituras-proceso'))}} {{activeRoute(route('escrituras-proceso2'))}}">
                        <a href="/administracion/escrituras_proceso"> Escrituras en proceso</a>
                    </li>
                    <li class="{{activeRoute(route('escrituras-apoyo'))}}">
                        <a href="/administracion/escrituras_apoyo"> Escrituras en apoyo</a>
                    </li>
                    {{-- <li class="{{activeRoute(route('admin-actos'))}}">
                        <a href="/administracion/actos"> Escrituras en terminadas</a>
                    </li> --}}
                </ul>
            </li>

            <li class="menu menu-heading">
                <div class="heading">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>CONFIGURACIÓN</span>
                </div>
            </li>

            <li class="menu {{activeRoute(route('admin-roles'))}} {{activeRoute(route('admin-usuarios'))}} {{activeRoute(route('user_profile'))}}">
                <a href="#usuariosCollapse" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>Seguridad</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="usuariosCollapse" data-bs-parent="#accordionExample">
                    @can('ver-usuarios')
                        <li class="{{activeRoute(route('admin-usuarios'))}}">
                            <a href="/administracion/usuarios"> Usuarios </a>
                        </li>
                    @endcan
                    @can('ver-rol')
                        <li class="{{activeRoute(route('admin-roles'))}}">
                            <a href="/administracion/roles"> Perfiles </a>
                        </li>
                        @endcan
                    <li class="{{activeRoute(route('user_profile'))}}">
                        <a href="/user/profile">Mi perfil</a>
                    </li>
                </ul>
            </li>
            <li class="menu {{activeRoute(route('admin-subprocesos'))}} {{activeRoute(route('admin-procesos_servicios'))}} {{activeRoute(route('admin-ocupaciones'))}} {{activeRoute(route('admin-servicios'))}} {{activeRoute(route('catalogos-paises'))}} {{activeRoute(route('catalogos-estados'))}} {{activeRoute(route('catalogos-municipios'))}} {{activeRoute(route('catalogos-colonias'))}}">
                <a href="#catalogos" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Catalogos</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="catalogos" data-bs-parent="#accordionExample">
                    @can('ver-servicios')
                        <li class="{{activeRoute(route('admin-servicios'))}}">
                            <a href="/administracion/servicios"> Actos</a>
                        </li>
                    @endcan
                    @can('ver-colonias')
                        <li class="{{activeRoute(route('catalogos-colonias'))}}">
                            <a href="/catalogos/colonias"> Colonias </a>
                        </li>
                    @endcan
                    @can('ver-estados')
                        <li class="{{activeRoute(route('catalogos-estados'))}}">
                            <a href="/catalogos/estados"> Estados  </a>
                        </li>
                    @endcan
                    @can('ver-municipios')
                        <li class="{{activeRoute(route('catalogos-municipios'))}}">
                            <a href="/catalogos/municipios"> Municipios </a>
                        </li>
                    @endcan
                    @can('ver-ocupaciones')
                        <li class="{{activeRoute(route('admin-ocupaciones'))}}">
                            <a href="/administracion/ocupaciones"> Ocupaciones</a>
                        </li>
                    @endcan
                    @can('ver-paises')
                        <li class="{{activeRoute(route('catalogos-paises'))}}">
                            <a href="/catalogos/paises"> Paises </a>
                        </li>
                    @endcan
                    @can('ver-procesos')
                        <li class="{{activeRoute(route('admin-procesos_servicios'))}}">
                            <a href="/administracion/procesos_servicios"> Procesos</a>
                        </li>
                    @endcan
                    <li class="{{activeRoute(route('admin-subprocesos'))}}">
                        <a href="/administracion/subprocesos"> Subprocesos</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
