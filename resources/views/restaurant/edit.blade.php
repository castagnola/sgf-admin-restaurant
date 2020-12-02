<!-- View stored in resources/views/greeting.blade.php -->
@extends('adminlte::page')
@section('plugins.Datatables',true)

@section('content_header')
    <h1>Información del restaurante</h1>
    @if (Session::get('success'))
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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Información  General del restaurante</h3>
        </div>
        <!-- /.card-header -->
        <form method="POST" action="{{ route('restaurant.edit',$restaurant) }}">
            @csrf
        <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class=" @error('nombre') is-invalid @enderror form-control form-control-lg" value="{{$restaurant->nombre}}" placeholder="Nombre">
                            @error('nombre')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" name="direccion" class=" @error('direccion') is-invalid @enderror form-control form-control-lg" value="{{$restaurant->direccion}}" placeholder="Dirección">
                            @error('direccion')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
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
                <div class="row">
                    <div class="col-sm-12">
                        <!-- textarea -->
                        <div class="form-group">
                            <label>Descripcion del producto</label>
                            <textarea type="text" name="descripcion" class=" @error('descripcion') is-invalid @enderror form-control form-control-lg" value="" placeholder="Descripcion">{{$restaurant->descripcion}}</textarea>
                            @error('descripcion')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <a  href="/restaurants" type="button" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        </form>
        <!-- /.card-body -->
    </div>
@stop

@section('js')
    <script>


    </script>
@stop
