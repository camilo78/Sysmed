@extends('layouts.app')

@section('content')
@if (session('status'))
<div class="alert alert-success alerta" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('status') }}
</div>
@endif

<div class="row">
    <div class="col-xl-12">
        @if ($message = Session::get('info'))
        <div class="alert alerta alert-info alert-dismissible d-flex flex-row">
            <i class="fas fa-fw fa-info-circle mr-3 mt-1"></i>
            <p>{{ $message }}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body" style="margin-top:-20px">
                <div class="row">
                    <div class="col-md-4 space">
                        <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-fw fa-user"></i> {{ __('Users') }}</h1>
                    </div>
                    <div class="col-md-4 space text-center">
                        <a href="{{ url('users/pdf/') }}" class="btn btn-outline-danger btn-sm">PDF</a>
                        <a href="{{ url('users/export/') }}" class="btn btn-outline-success btn-sm">Excel</a>

                        <a href="{{ route('users.trash') }}"
                            class="btn btn-outline-secondary btn-sm">{{ 'Papelera' }}</a>
                        <a href="{{ route('users.create') }}" class="btn btn-outline-info btn-sm">{{ __('New') }}</a>
                    </div>
                    <div class="col-md-4 space">
                        <form method="GET" action="{{ route('users.index') }}">
                            <div class="input-group mb-3 input-group-sm">
                                <input type="text" class="form-control" name="name" placeholder="{{ __('Search') }}"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="submit" id="button-addon2"><i
                                            class="fas fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-responsive-sm small">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Rol</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="show" data-id="{{ $user->id }}">{{ $user->name }}</td>
                            <td class="show" data-id="{{ $user->id }}">{{ $user->email }}</td>
                            <td class="show" data-id="{{ $user->id }}">{{ $user->phone }}</td>
                            <td class="show" data-id="{{ $user->id }}">
                                @if(\Carbon\Carbon::parse($user->date)->age === 0)
                                {{ \Carbon\Carbon::parse($user->date)->diff(\Carbon\Carbon::now())->format('%m meses %d días') }}
                                @elseif(\Carbon\Carbon::parse($user->date)->age < 3)
                                    {{ \Carbon\Carbon::parse($user->date)->age }} año
                                    {{ \Carbon\Carbon::parse($user->date)->diff(\Carbon\Carbon::now())->format('%m meses') }}
                                    @elseif(\Carbon\Carbon::parse($user->date)->age === 1)
                                    {{ \Carbon\Carbon::parse($user->date)->age }} año
                                    @else
                                    {{ \Carbon\Carbon::parse($user->date)->age }} años
                                    @endif
                            </td>
                            <td class="show" data-id="{{ $user->id }}">
                                {{ !empty($user->roles()->first()->name) ? $user->roles()->first()->name: 'S/R' }}</td>
                            <td class="text-center">
                                <form class="form-delete" id="{{ $user->id }}"
                                    action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    @can('users.edit')
                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('users.destroy')
                                        @if (auth()->id() != $user->id)
                                        <button class="btn btn-outline-danger btn-sm submit" type="button"
                                            data-id="{{ $user->id }}"
                                            data-msj="¿Realmente quiere eliminar los datos de <b>{{ $user->name }}</b>?"
                                            type="button"><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    @endif
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="text-center text-danger">No hay coincidencias para esa busqueda</div>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex table-responsive-sm" style="margin-bottom:-25px">
                    <div class="ml-auto p-2 pagination-sm">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
    var URLSHOW = '{{URL::to('users')}}/';

    $( document ).ready(function() {

    $('.show').click(function() {
        var id = $(this).attr('data-id')
        window.location.href = URLSHOW + id;
        return false;
    });

    $(".submit").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var msj = $(this).attr('data-msj');
        $.confirm({
            title: '!Confirme esta acción!',
            content: msj,
            type: 'red',
            icon: 'fas fa-fw fa-exclamation-circle',
            theme: 'modern',
            buttons: {
                si: {
                    btnClass: 'btn-red',
                    action: function(){
                        document.getElementById(id).submit()
                    }
                },
                no: {
                    btnClass: 'btn-blue',
                    action: function(){
                    }
                },

            }
        });
    });
});

</script>
@endsection
