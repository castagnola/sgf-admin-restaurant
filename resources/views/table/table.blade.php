<!-- View stored in resources/views/greeting.blade.php -->
@extends('adminlte::page')
@section('plugins.Datatables',true)

@section('content_header')
    <h1>Administración de Mesas</h1>
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
    <h1>Información de Mesas</h1>
    <div class="col-3" style="">
        <button type="button" placeholder="Agregar Mesa" class="btn btn-success" data-toggle="modal"
                data-target="#addRestaurant"><i class="fas fa-plus"></i></button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Mesa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('tables.store')}}">
                    <div class="modal-body">
                        @csrf
                        <div class="card-body">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-text-height"></i></span>
                                </div>
                                <input type="text" name="numero_mesa"
                                       class=" @error('numero_mesa') is-invalid @enderror form-control form-control-lg"
                                       placeholder="Numero de mesa" required>
                            </div>
                            @error('numero_mesa')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                </div>
                                <input type="number" name="puestos"
                                       class=" @error('puestos') is-invalid @enderror form-control form-control-lg"
                                       placeholder="Puestos de la mesa" required>
                            </div>
                            @error('puestos')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label>Restaurante</label>
                                </div>

                            </div>
                            <div class="input-group mb-3">
                                <select name="restaurante_id" class="form-control form-control-lg"
                                        class=" @error('puestos') is-invalid @enderror form-control form-control-lg"
                                        required>
                                    @foreach($restaurants as $value )
                                        <option value="{{$value->id}}">{{$value->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
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
            <th>Numero de mesa</th>
            <th>Puesto</th>
            <th>Disponibilidad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tables as $value )
            <tr>
                <td>{{ $value->numero_mesa }}</td>
                <td>{{ $value->puestos }}</td>
                <td>{{ $value->disponible ? 'DISPONIBLE' : 'RESERVADA' }}</td>
                <td>
                    <form method="POST" action="{{ route('tables.destroy',[$value->id])}}">
                        @csrf
                        @method('DELETE')
                        <a href="/tables/{{$value->id}}/edit" type="button" class="btn btn-info"><i
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
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@stop
