@extends('templates.admin')

@section('css')

@endsection

@section('content')
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="true">Foto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="false">Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="false">Información</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">Contraseña</a>
                        </li>
                    </ul>
                    <div class="tab-content py-4" id="myTabContent">
                        <div class="tab-pane fade  m-auto" id="photo" role="tabpanel" aria-labelledby="photo-tab" style="max-width: 800px">
                            <users-form-photo :user="{{ $user->personal_information }}"></users-form-photo>
                        </div>
                        <div class="tab-pane fade show active m-auto" id="user" role="tabpanel" aria-labelledby="user-tab" style="max-width: 800px">
                            <users-form-user :user="{{ $user }}"></users-form-user>
                        </div>
                        <div class="tab-pane fade m-auto" id="information" role="tabpanel" aria-labelledby="information-tab" style="max-width: 800px">
                            <users-form-information :user="{{ $user->personal_information }}"></users-form-information >
                        </div>
                        <div class="tab-pane fade m-auto" id="password" role="tabpanel" aria-labelledby="password-tab" style="max-width: 800px">
                            <users-form-password :user="{{ $user->personal_information }}"></users-form-password>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/nav.js') }}" defer></script>

@endsection
