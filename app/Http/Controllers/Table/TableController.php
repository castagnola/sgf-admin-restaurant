<?php

namespace App\Http\Controllers\Table;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TableRestaurant\TableRestaurantController;
use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Http\Resources\Table\TableCollection;
use App\Models\Parametric;
use App\Models\Restaurant;
use App\Models\TableRestaurant;
use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

const NUMBER_TABLES_ID = 1;
class TableController extends Controller
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
        $restaurants = Restaurant::where('status', 1)->get();
        $dataTable = Tables::where('status', 1)->get();
        return view('table.table', ['tables' => TableCollection::collection($dataTable), 'restaurants' => RestaurantCollection::collection($restaurants)]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'numero_mesa' => 'required',
            'puestos' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
          $isValidate=  $this->calculateTablesByRestaurant($request);

        if(!$isValidate){
            return back()->with('warning', 'Error, El numero de mesas por restaurante es de 15, ya se asignaron!');

        }

        try {

            $tables = new Tables();
            $tables->numero_mesa = $request->numero_mesa;
            $tables->puestos = intval($request->puestos);
            $tables->disponible = true;
            $tables->status = true;
            $tables->save();

            (new TableRestaurantController)->store($request->restaurante_id, $tables->id);

            return redirect('/tables')->with('success', 'Mesa creada correctamente!');

        } catch (\Exception $e) {
            dd($e);
            return back()->with('warning', 'Error, favor comunicarse con un administrador!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $table = Tables::findOrFail($id);
            return view('table.edit', ['table' => $table]);

        } catch (\Exception $e) {
            return back()->with('warning', 'Error, favor comunicarse con un administrador!');
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
        $validator = Validator::make($request->all(), [
            'numero_mesa' => 'required',
            'puestos' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }

        try {
            $tables = Tables::findOrFail($id);
            $tables->numero_mesa = $request->numero_mesa;
            $tables->puestos = intval($request->puestos);
            $tables->disponible = true;
            $tables->status = true;
            $tables->save();
            return back()->with('success', 'Mesa actualizada correctamente!');

        } catch (\Exception $e) {

            return back()->with('warning', 'Error, al eliminar favor comunicarse con un administrador!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $restaurant = Tables::findOrFail($id);
            $restaurant->status = false;
            $restaurant->save();
            return back()->with('success', 'Mesa eliminada correctamente!');

        } catch (\Exception $e) {
            return back()->with('warning', 'Error, al eliminar favor comunicarse con un administrador!');
        }
    }

    /**
     * Funcion para validar El número de mesas para cada restaurante es fijo y es de 15 parametrica que se saca desde la base de datos.
     * @param Request $request
     * @return bool
     */
    private function calculateTablesByRestaurant(Request $request)
    {
        $countLimit = Parametric::where('id',NUMBER_TABLES_ID)->value('valor_parametrica');
        $numberTablesRestaurant = TableRestaurant::where('id_restaurante', $request->restaurante_id)->count();
        return intval($countLimit) === intval($numberTablesRestaurant) ? false : true;

    }

    /**
     * Funcion para determinar la reserva de la mesa
     * @param $id
     */

    public  function bookingTable($id){

        $tableReserve = Tables::findOrFail($id);
        $tableReserve->disponible = false;
        $tableReserve->save();

    }
}
