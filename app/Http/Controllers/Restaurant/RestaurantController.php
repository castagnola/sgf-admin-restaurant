<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Models\Cities;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RestaurantController extends Controller
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
        $cities = Cities::all();
        $dataTable = Restaurant::with('cities')->where('status', 1)->get();
        return view('restaurant.restaurant', ['restaurants' => RestaurantCollection::collection($dataTable), 'cities' => CityCollection::collection($cities)]);
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
            'nombre' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $path = $request->file('photo');
            $nombre = time() . "_" . $path->getClientOriginalName();
            \Storage::disk('public')->put($nombre, \File::get($path));

            $restaurant = new Restaurant();
            $restaurant->nombre = $request->nombre;
            $restaurant->descripcion = $request->descripcion;
            $restaurant->direccion = $request->direccion;
            $restaurant->id_ciudad = $request->id_ciudad;
            $restaurant->url_foto = $nombre;
            $restaurant->status = true;
            $restaurant->save();

            return redirect('/restaurants')->with('success', 'Restaurante creado correctamente!');

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
            $cities = Cities::all();
            $restaurant = Restaurant::findOrFail($id);
            return view('restaurant.edit', ['restaurant' => $restaurant,'cities'=>CityCollection::collection($cities)]);

        } catch (\Exception $e) {
            return back()->with('warning', 'Error, al eliminar favor comunicarse con un administrador!');
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
            'nombre' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }

        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->nombre = $request->nombre;
            $restaurant->descripcion = $request->descripcion;
            $restaurant->direccion = $request->direccion;
            $restaurant->id_ciudad =  $request->id_ciudad;
            $restaurant->status = true;
            $restaurant->save();
            return back()->with('success', 'Restaurante actualizado correctamente!');

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
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->status = false;
            $restaurant->save();
            return back()->with('success', 'Restaurante eliminado correctamente!');

        } catch (\Exception $e) {
            return back()->with('warning', 'Error, al eliminar favor comunicarse con un administrador!');
        }
    }
}
