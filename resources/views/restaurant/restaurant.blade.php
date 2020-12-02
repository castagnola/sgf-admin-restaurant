<!-- View stored in resources/views/greeting.blade.php -->
@extends('adminlte::page')
@section('plugins.Datatables',true)

@section('content_header')
    <h1>Administración de Restaurantes</h1>
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
    <h1>Información de Restaurantes</h1>
    <div class="col-3" style="">
        <button type="button" placeholder="Agregar Restaurante" class="btn btn-success" data-toggle="modal"
                data-target="#addRestaurant"><i class="fas fa-plus"></i></button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Restaurante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('restaurants.store')}}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                </div>
                                <input type="text" name="nombre"
                                       class=" @error('nombre') is-invalid @enderror form-control form-control-lg"
                                       placeholder="Nombre" required>
                            </div>
                            @error('nombre')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="direccion"
                                       class=" @error('direccion') is-invalid @enderror form-control form-control-lg"
                                       placeholder="Dirección" required>
                                </div>
                            @error('direccion')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-audio-description"></i></span>
                                </div>
                                <textarea type="text" name="descripcion"
                                          class=" @error('descripcion') is-invalid @enderror form-control form-control-lg"
                                          value="" placeholder="Descripcion" required></textarea>
                                </div>
                                @error('descripcion')
                                {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                                <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                                @enderror
                        </div>
                        <div class="input-group mb-3">
                            <label for="exampleInputFile">Ciudad</label>
                            <div class="input-group">
                                <select name="id_ciudad" class="form-control form-control-lg"
                                        class=" @error('id_ciudad') is-invalid @enderror form-control form-control-lg"
                                        required>
                                    @foreach($cities as $value )
                                        <option value="{{ $value->id }}">{{$value->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <label for="exampleInputFile">Foto del establecimiento</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="form-control-file" name="photo" id="photo">
                                    <label class="custom-file-label" for="photo">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
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
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Foto</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($restaurants as $value )
            <tr>
                <td>{{ $value->nombre }}</td>
                <td>{{ $value->descripcion }}</td>
                <td>{{ $value->direccion }}</td>
                <td>{{ $value->cities->nombre }}</td>
                <td>
                    <img src="{{ asset('storage/'.$value->url_foto) }} "  width="100">
                </td>
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
    <script>
        $(document).ready(function () {
            $('#example').DataTable();

        });

    </script>
@stop
