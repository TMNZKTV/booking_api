<?php

namespace App\Http\Controllers;

use App\Http\Resources\TableResource;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Использую ресурс, в нем стат.метод collection, куда передаю модель
        // с тем полем, к которому привязаны бронирования
        // ->get() в конце
        return TableResource::collection(Table::with('reservations')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Table::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TableResource
     */
    public function show($id)
    {
        // Использую новый экземпляр ресурса, куда передаю модель
        // с полем, к которому привязаны бронирования
        // метод findOrFail
        return new TableResource(Table::with('reservations')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return TableResource
     */
    public function update(Request $request, $id)
    {
//        $table = Table::findOrFail($id);
//        $table->update($request->all());
//
//        return Table::all();
        $table = new TableResource(Table::with('reservations')->findOrFail($id));
        $table->update($request->all());

        return new TableResource(Table::with('reservations')->findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Table::destroy($id);
    }
}
