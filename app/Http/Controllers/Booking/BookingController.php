<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Table\TableController;
use App\Http\Resources\Booking\BookingCollection;
use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Http\Resources\Table\TableCollection;
use App\Models\Bookings;
use App\Models\Restaurant;
use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Tables::where('status', 1)
            ->where('disponible',1)
            ->get();
        $dataTable = Bookings::with('tables')->get();
        return view('booking.booking', [
            'tables' => TableCollection::collection($tables),
            'bookings' => BookingCollection::collection($dataTable),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $tables = new Bookings();
            $tables->id_mesa = $request->mesa_id;
            $tables->nombre_comensal = $request->nombre_comensal;
            $tables->fecha_reserva = $request->fecha_reserva;
            $tables->comentarios = $request->comentarios;
            $tables->save();

            (new TableController)->bookingTable($request->mesa_id);

            return back()->with('success', 'Reserva creada correctamente!');

        } catch (\Exception $e) {
            return back()->with('warning', 'Error, favor comunicarse con un administrador!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
