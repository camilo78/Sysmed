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
                        <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-fw fa-users"></i> {{ 'Pacientes' }}</h1>
                    </div>
                    <div class="col-md-4 space text-center">
                        <a href="{{ url('patients/pdf/') }}" class="btn btn-outline-danger btn-sm">PDF</a>
                        <a href="{{ url('patients/export/') }}" class="btn btn-outline-success btn-sm">Excel</a>

                        <a href="{{ route('patients.trash') }}"
                            class="btn btn-outline-secondary btn-sm">{{ 'Papelera' }}</a>
                        <a href="{{ route('patients.create') }}" class="btn btn-outline-info btn-sm">{{ __('New') }}</a>
                    </div>
                    <div class="col-md-4 space">
                        <form method="GET" action="{{ route('patients.index') }}">
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
                        	<th scope="col">Expediente</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Documento</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Sx</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
              @forelse($patients as $patient)
                        <tr>
                        	<td style="vertical-align:middle;"><a href="#" class="show text-decoration-none" data-id="{{ $patient->id }}"><i class="fas fa-folder-open"></i> {{ $patient->patient_code }}</a></td>
                            <td style="vertical-align:middle;">{{ ucwords($patient->name1 .' '. $patient->name2) }}</td>
                            <td style="vertical-align:middle;">{{ ucwords($patient->surname1. ' ' .$patient->surname2) }}</td>
                            <td style="vertical-align:middle;"><a class="text-decoration-none" href="mailto:{{ $patient->email }}">{{ $patient->email }}</a></td>
                            <td style="vertical-align:middle;">
                                <a class="text-decoration-none" href="tel:{{ $patient->phone1 }}">{{ $patient->phone1 }}</a><br>
                                <a class="text-decoration-none" href="tel:{{ $patient->phone2 }}">{{ $patient->phone2 }}</a>
                            </td>
                            <td>{{$patient->document_type}}<br>{{$patient->document}}</td>
                            <td class="font-weight-bold" style="vertical-align:middle; color: {{ $patient->status === "active" ? "#1cc88a" : "grey" }}" data-id="{{ $patient->id }}">{{ ucwords(__($patient->status))}}</td>
                            <td style="vertical-align:middle;">
                                @if(\Carbon\Carbon::parse($patient->birth)->age === 0)
                                {{ \Carbon\Carbon::parse($patient->birth)->diff(\Carbon\Carbon::now())->format('%m m + %d d') }}
                                @else(\Carbon\Carbon::parse($patient->date)->age < 3)
                                    {{ \Carbon\Carbon::parse($patient->birth)->age }} A +
                                    {{ \Carbon\Carbon::parse($patient->birth)->diff(\Carbon\Carbon::now())->format('%m m') }}
                                @endif
                            </td>
                            <td style="vertical-align:middle;">{{ __($patient->gender) }}</td>
                            <td class="text-center" style="vertical-align:middle;">
                                <form class="form-delete" id="{{ $patient->id }}"
                                    action="{{ route('patients.destroy', $patient->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    @can('patients.edit')
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('patients.edit', $patient->id) }}"
                                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('patients.destroy')
                                        <button class="btn btn-outline-danger btn-sm submit" type="button"
                                            data-id="{{ $patient->id }}"
                                            data-msj="¿Realmente quiere eliminar los datos de <b>{{ $patient->name }}</b>?"
                                            type="button"><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="text-center text-danger">No hay pacientes registrados</div>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex table-responsive-sm" style="margin-bottom:-25px">
                    <div class="ml-auto p-2 pagination-sm">{{ $patients->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

<style>
    .show{
        color:orange;
    }
    .show:hover{
        color:red;
    }
</style>

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
    var URLSHOW = '{{URL::to('patients')}}/';

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