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
    <h1>Reservar Mesa</h1>
    <div class="col-3" style="">
        <button type="button" placeholder="Agregar Reserva" class="btn btn-success" data-toggle="modal"
                data-target="#addRestaurant"><i class="fas fa-plus"></i></button>
    </div>
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
                <form method="POST" action="{{route('bookings.store')}}">
                    <div class="modal-body">
                        @csrf
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label>Mesa Disponible</label>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <select name="mesa_id" class="form-control form-control-lg"
                                        class=" @error('mesa') is-invalid @enderror form-control form-control-lg"
                                        required>
                                    @foreach($tables as $value )
                                        <option value="{{$value->id}}">{{$value->numero_mesa}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3">
                            </div>
                            @error('direccion')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label>Nombre Comensal</label>
                                </div>
                            </div>
                            <input type="text" name="nombre_comensal"
                                   class=" @error('nombre_comensal') is-invalid @enderror form-control form-control-lg"
                                   placeholder="nombre_comensal" required>
                            <div class='col-sm-6'>
                                <div class="form-group">
                                    <label>Fecha de reserva</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input id="birth-date" name="fecha_reserva" type="text" class="form-control"
                                               data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                                               data-mask="" im-insert="false" placeholder="dd/mm/yyyy" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-audio-description"></i></span>
                                </div>
                                <textarea type="text" name="comentarios"
                                          class=" @error('comentarios') is-invalid @enderror form-control form-control-lg"
                                          value="" placeholder="Comentarios" required></textarea>
                            </div>
                            @error('descripcion')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                            @error('descripcion')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>

        $(document).ready(function () {
            $('#example').DataTable();
            $('#birth-date').mask('00/00/0000');

        });


    </script>
@stop
