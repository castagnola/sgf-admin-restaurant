<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Table\TableController;
use App\Http\Resources\Booking\BookingCollection;
use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Http\Resources\Table\TableCollection;
use App\Models\Bookings;
use App\Models\Restaurant;
use App\Models\TableRestaurant;
use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

const MAX_DAY_BOOKINGS = 15;
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
            ->where('disponible', 1)
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
    public function add(Request $request)
    {
        try {
            $restaurants = Restaurant::with('tables_restaurant.tables.bookings')
                ->where('status', 1)->get();

            return view('booking\bookingcreate', [
                'restaurants' => RestaurantCollection::collection($restaurants),
                'fecha_reserva' => $request->fecha_reserva
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('warning', 'Error, favor comunicarse con un administrador!');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_mesa' => 'required',
                'nombre_comensal' => 'required',
                'fecha_reserva' => 'required',
                'restaurant_id' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (Bookings::where('fecha_reserva', $request->fecha_reserva)->count() === MAX_DAY_BOOKINGS) {
                return back()->with('warning', 'Error, ha cumplido el limite de 15 reservas para a fecha: ' . $request->fecha_reserva);
            }


            $tables = new Bookings();
            $tables->id_mesa = $request->id_mesa;
            $tables->nombre_comensal = $request->nombre_comensal;
            $tables->fecha_reserva = $request->fecha_reserva;
            $tables->comentarios = empty($request->comentarios) ? 'N/A' : $request->comentarios;
            $tables->save();

            (new TableController)->bookingTable($request->id_mesa);

            return back()->with('success', 'Reserva creada correctamente!');

        } catch (\Exception $e) {

            return back()->with('warning', 'Error, favor comunicarse con un administrador!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('booking\bookingcreate');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getTables(Request $request)
    {
        try {
            $tables = TableRestaurant::whereDoesntHave('tables.bookings', function ($q) use ($request) {
                $q->where('bookings.fecha_reserva', '=', $request->fecha_reserva);
            })->where('id_restaurante', $request->restaurant_id)->get();

            return $tables->pluck('tables');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
