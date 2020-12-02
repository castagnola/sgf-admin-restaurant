@extends('adminlte::page')
@section('plugins.Datatables',true)
@section('content_header')
    <h1>Creación de una Reserva</h1>
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
    <div class="card card-primary">
        <form method="POST" action="{{  !isset($restaurants) ? route('booking.add') : route('bookings.store') }}">
            @csrf
            @method('POST')
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-6">
                            <label>Seleccione una Fecha de la reserva</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input
                                    <?= !isset($restaurants) ? '' : 'readonly'  ?>  class="datepicker form-control form-control-lg"
                                    id="fecha_reserva" name="fecha_reserva"
                                    value="{{ isset($fecha_reserva) ? $fecha_reserva :'' }}"
                                    data-date-format="mm/dd/yyyy" autocomplete="off" required>

                                <div class="input-group-addon">
                                    <span class="fas fa-calendar-alt fa-2x"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($restaurants))
                        <div class="col-sm-6">
                            <div class="input-group mb-6">
                                <label for="exampleInputFile">Restaurantes Disponibles</label>
                                <div class="input-group">
                                    <select name="restaurant_id" id="restaurant_id" class="form-control form-control-lg"
                                            class=" @error('restaurant_id') is-invalid @enderror form-control form-control-lg"
                                            required>
                                        <option value="" selected disabled>Seleccione un restaurante</option>
                                        @foreach($restaurants as $value )
                                            <option value="{{ $value->id }}">{{$value->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if(isset($restaurants))
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group mb-6">
                                <label>Nombre Comensal</label>
                                <div class="input-group">
                                    <input type="text" name="nombre_comensal"
                                           class=" @error('nombre_comensal') is-invalid @enderror form-control form-control-lg"
                                           placeholder="nombre_comensal" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group mb-6">
                                <label for="exampleInputFile">Mesas Disponibles</label>
                                <div class="input-group">
                                    <select name="id_mesa" id="id_mesa" class="form-control form-control-lg"
                                            class=" @error('id_mesa') is-invalid @enderror form-control form-control-lg"
                                            required>
                                        <option value="0">Seleccione una mesa</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group mb-12">
                                <label>Comentarios</label>
                                <div class="input-group">
                                <textarea style="  height: 150px;" name="comentarios"
                                          class=" @error('comentarios') is-invalid @enderror form-control form-control-lg"
                                          placeholder="Comentarios"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-footer">
                    <a href="/bookings" type="button" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
                    <button <?= isset($restaurants) ? 'style="display:none"' : '' ?> type="submit"
                            class="btn btn-primary">Consultar disponibilidad
                    </button>
                    <button <?= isset($restaurants) ? '' : 'style="display:none"' ?> type="submit"
                            class="btn btn-primary">Reservar
                    </button>
                </div>
            </div>
        </form>
        <!-- /.card-body -->
    </div>
@stop
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {

            @if(isset($restaurants))
            $(document).off('.datepicker.data-api');
            @endif

            $('#restaurant_id').change(function () {
                console.log('llegaaaa')
                recargarLista();
            })
        })
        function recargarLista() {
            $.ajax(({
                type: "POST",
                url: "{{route('booking.getTables')}}",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "restaurant_id": $('#restaurant_id').val(),
                    "fecha_reserva": $('#fecha_reserva').val()
                },
                success: function (response) {
                    $("#id_mesa").empty();
                    if (response.length > 0) {
                        $.each(response, function (i, table) {
                            $("#id_mesa").append('<option  value="' + table.id + '">' + table.numero_mesa + '</option>')
                        })
                    } else {
                        $("#id_mesa").append('<option   value=""> No hay mesas disponibles</option>')
                    }
                }
            }))
        }
    </script>
@stop
