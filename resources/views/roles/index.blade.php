@extends('layouts.app')
@section('content')
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
        </div>
    </div>
    <table class="table table-hover small" id="dtPluginExample" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col" class="text-center">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($role as $rol)
            <tr>
                <td>{{ $rol->name }}</td>
                <td>{{ $rol->description }}</td>
                <td class="text-center">
                    <form class="form-delete" id="{{ $rol->id }}"
                          action="{{ route('roles.destroy', $rol->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="btn-group" role="group" aria-label="Basic example">
                            @can('users.edit')
                                <button class="btn btn-outline-info btn-sm show" data-id="{{ $rol->id }}"><i
                                        class="far fa-eye"></i></button>
                                <a href="{{ route('roles.edit', $rol->id) }}"
                                   class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('roles.destroy')
                                <button class="btn btn-outline-danger btn-sm submit" type="button"
                                        data-id="{{ $rol->id }}"
                                        data-msj="¿Realmente quiere eliminar el rol <b>{{ $rol->name }}</b>?"
                                        type="button"><i class="fas fa-trash-alt"></i>
                                </button>
                            @endcan
                        </div>
                    </form>
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>

@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css"/>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>
    <script type="text/javascript">
        var URLSHOW = '{{URL::to('roles')}}/';
        var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        var f = new Date();
        var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
        var tableTitle = 'Roles';
        var tableSubTitle = 'Total de usuarios al ' + fecha;
        var tableBS4 = $('#dtPluginExample').DataTable({
            drawCallback: function () {
                $('#dtPluginExample_paginate ul.pagination').addClass("pagination-sm");
                $('button.btn').removeClass("btn-secondary");

            },
            stateSave: true,
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            },
            responsive: true,
            dom: "<'row rio'<'col-sm-12 text-center col-md-4'B><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row small'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            buttons: {
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>',
                        className: 'btn-primary btn-sm',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: tableTitle,
                        messageTop: tableSubTitle,
                        titleAttr: 'Exportar Excel'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i>',
                        className: 'btn-primary btn-sm',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: tableTitle,
                        exportOptions: {
                            columns: [0, 1]
                        },
                        messageTop: tableSubTitle,
                        titleAttr: 'Exportar PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i>',
                        className: 'btn-primary btn-sm',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: tableTitle,
                        messageTop: tableSubTitle,
                        titleAttr: 'Imprimir Tabla'
                    },
                    {
                        text: '<i class="fas fa-plus-circle"></i>',
                        className: 'btn-primary btn-sm',
                        init: (api, node, config) => $(node).removeClass('btn-secondary'),
                        action: function (e, dt, node, config) {
                            window.location.href = '{{ route('roles.create') }}';
                            return false;
                        }
                    }
                ],
            }
        });
        // Add a row for the Title & Subtitle in front of the first row of the wrapper
        var divTitle = ''
            + '<div class="col-sm-12 col-md-4">'
            + '<h3> <i class="fas fa-users"></i>  ' + tableTitle + '</h3>'
            + '</div>';
        $(divTitle).prependTo('.rio');

        $('tfoot tr th').removeClass("bg-warning bg-light bg-success text-left text-center text-right").addClass("bg-dark text-white").css("font-size", "0.85rem");
        $('tfoot tr th:eq(1)').addClass("text-left");
        $('tfoot tr th:eq(6)').addClass("text-right");

        $('.show').click(function () {
            var id = $(this).attr('data-id')
            window.location.href = URLSHOW + id;
            return false;
        });
        $("#dtPluginExample").on("click", ".show", function (e) {
            var id = $(this).attr('data-id')
            window.location.href = URLSHOW + id;
            return false;
        });
        $("#dtPluginExample").on("click", ".submit", function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var msj = $(this).attr('data-msj');
            $.confirm({
                title: '!Confirme esta acción!',
                content: msj,
                type: 'red',
                icon: 'fas fa-fw fa-exclamation-circle',
                theme: 'modern',
                backgroundDismiss: 'no',
                escapeKey: 'no',
                buttons: {
                    si: {
                        btnClass: 'btn-red',
                        action: function () {
                            document.getElementById(id).submit()
                        }
                    },
                    no: {
                        btnClass: 'btn-blue',
                        action: function () {
                        }
                    },
                }
            });
        });

    </script>
@endsection
