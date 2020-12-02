<!-- View stored in resources/views/greeting.blade.php -->
@extends('adminlte::page')
@section('plugins.Datatables',true)

@section('content_header')
    <h1>Administración de Reservas</h1>
    @if (session('success'))
        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    @if (session('warning'))
        <div class="col-sm-12">
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
@stop

@section('content')
    <h1>Mis Reservas</h1>
    <form method="POST" action="{{route('booking.generate')}}">
        @csrf
        @method('POST')
        <button type="submit" placeholder="Agregar Reserva" class="btn btn-success"
        ><i class="fas fa-plus"></i></button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="addRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Reserva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <table id="example" class="table table-striped table-bordered" style="width:100%;">
        <thead>
        <tr>
            <th>Numero Mesa</th>
            <th>Comensal</th>
            <th>Fecha Reserva</th>
            <th>Comentarios</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bookings as $value )
            <tr>
                <td>{{ $value->tables->numero_mesa }}</td>
                <td>{{ $value->nombre_comensal }}</td>
                <td>{{ $value->fecha_reserva }}</td>
                <td>{{ $value->comentarios }}</td>
                <td>
                    <form method="POST" action="{{ route('restaurants.destroy',[$value->id])}}">
                        @csrf
                        @method('DELETE')
                        <a href="/restaurants/{{$value->id}}/edit" type="button" class="btn btn-info"><i
                                class="fas fa-edit"></i></a>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop

@section('js')


    <script type="text/javascript">

        $(function () {
            $('#datetimepicker1').datepicker();
        });
    </script>
    <script>

        $(document).ready(function () {
            $('#example').DataTable();
            //  $('#birth-date').mask('00/00/0000');
            //  $('.datepicker-here').datepicker([options])

            $('.datepicker-here').data('datepicker')

        });


    </script>
@stop
