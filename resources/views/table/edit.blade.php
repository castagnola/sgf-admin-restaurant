<!-- View stored in resources/views/greeting.blade.php -->
@extends('adminlte::page')
@section('plugins.Datatables',true)

@section('content_header')
    <h1>Información de la mesa</h1>
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
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Información  General de la mesa</h3>
        </div>
        <!-- /.card-header -->
        <form method="POST" action="{{ route('table.edit',$table) }}">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Numero de mesa</label>
                            <input type="text" name="numero_mesa"
                                   class=" @error('numero_mesa') is-invalid @enderror form-control form-control-lg" value="{{$table->numero_mesa}}"
                                   placeholder="Numero de mesa" >
                            @error('numero_mesa')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Puestos</label>
                            <input type="number" name="puestos"
                                   class=" @error('puestos') is-invalid @enderror form-control form-control-lg"
                                   placeholder="Puestos de la mesa" value="{{$table->puestos}}">
                            @error('puestos')
                            {{-- <div class="alert alert-danger">{{ $message }}</div>--}}
                            <div style="margin-top: 2px" class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12" style="text-align: center">
                        <div class="form-group">
                            <label>Disponibilidad</label>
                            <input type="text" name="disponible" style="text-align: center"
                                   class=" form-control form-control-lg"
                                   placeholder="Puestos de la mesa" value="{{$table->disponible ? 'Disponible' : 'RESERVADA'}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a  href="/tables" type="button" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
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
