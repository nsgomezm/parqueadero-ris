<div class="wrapper active">
    <div class="top_navbar">
        <div class="hamburger">
            <div class="hamburger__inner">
            <div class="one"></div>
            <div class="two"></div>
            <div class="three"></div>
            </div>
        </div>
        <div class="menu">
            <div class="logo">
                {{ config('app.name', 'Laravel') }}
            </div>
            <div class="right_menu">
                <ul class="mb-0">
                    <li><i class="fas fa-user"></i>
                    <div class="profile_dd">
                        <div class="profile container text-center">
                            <div class="img img-circle ">
                                <img src="{{ Auth::user()->load('personal_information')->personal_information->photo }}" alt="Foto" class="rounded-circle" style="height: 80px; width: 80px">
                            </div>
                            <div>
                            <p>Bienvenid@</p>
                            <h5 style="color: white;" >{{ Auth::user()->nickname }}</h5>
                            </div>
                        </div>
                        <div class="dd_item link-yellow"><a class="d-block" href="/users/edit-information/">Perfil </a> </div>
                        <div class="dd_item link-yellow"><a class="d-block" href="#"  data-toggle="modal" data-target="#canchePassword">Cambiar contraseña  </a> </div>
                        <div class="dd_item link-yellow"><a class="d-block" href="/logout">Cerrar sisión </a> </div>
                    </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main_container">
        <div class="sidebar">
            <div class="sidebar__inner menujq">
                <ul>
                    <li>
                    <a href="/home" class="icon">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="title">Inicio</span>
                    </a>
                    </li>

                    <li>
                    <a href="/users/list" class="icon">
                        <span class="icon"><i class="fas fa-users"></i></span>
                        <span class="title">Usuarios</span>
                    </a>
                    </li>

                    <li>
                    <a href="javascript:void();" class="icon">
                        <span class="icon"><i class="fab fa-delicious"></i></span>
                        <span class="title">Opciones 1</span>
                    </a>
                    <ul>
                        <li>
                        <a href="#" class="icon">
                            <span class="icon"><i class="fab fa-delicious"></i></span>
                            <span class="title">Opcion 1</span>
                        </a>
                        </li>
                        <li>
                        <a href="#" class="icon">
                            <span class="icon"><i class="fab fa-delicious"></i></span>
                            <span class="title">Opcion 2</span>
                        </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void();" class="icon">
                        <span class="icon"><i class="fab fa-delicious"></i></span>
                        <span class="title">Opciones 2</span>
                    </a>
                    <ul>
                        <li>
                        <a href="#" class="icon">
                            <span class="icon"><i class="fab fa-delicious"></i></span>
                            <span class="title">Opcion 1</span>
                        </a>
                        </li>
                        <li>
                        <a href="#" class="icon">
                            <span class="icon"><i class="fab fa-delicious"></i></span>
                            <span class="title">Opcion 2</span>
                        </a>
                        </li>
                        <li>
                        <a href="#" class="icon">
                            <span class="icon"><i class="fab fa-delicious"></i></span>
                            <span class="title">Opcion 3</span>
                        </a>
                        </li>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="containerr" id="app">
            @yield('content')
            <div class="modal fade" id="canchePassword" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 20000">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Actualizar contraseña</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <users-form-password :user="{{ Auth::user() }}"></users-form-password>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

