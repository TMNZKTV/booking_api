<?php

namespace App\Http\Controllers;

use App\Models\ThirdLayout;
use Illuminate\Http\Request;

class ThirdLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $layout = ThirdLayout::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Возвращаю ТретийМакет, на котором вызываю метод Create, куда передаю запрос (в запросе выбираю all())
        return ThirdLayout::create($request->all());
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThirdLayout $layout, $id)
    {
        $table = ThirdLayout::findOrFail($id);
        $table->update($request->all());

        return $layout = ThirdLayout::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ThirdLayout $layout, $id)
    {
        return ThirdLayout::destroy($id);
    }
}
