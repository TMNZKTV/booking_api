<?php

namespace App\Http\Controllers;

use App\Models\SecondLayout;
use Illuminate\Http\Request;

class SecondLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $layout = SecondLayout::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return SecondLayout::create($request->all());
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
    public function update(Request $request, SecondLayout  $layout, $id)
    {
        // $table - создал переменную, которая находит конкретный стол по модели SecondLayout
        // Использую стат.метод finOrFail, куда передаю $id
        // В этой переменной использую метод update
        // В update помещаю весь $request, в котором выбираю all();
        $table = SecondLayout::findOrFail($id);
        $table->update($request->all());

        // Возвращаю Макет - модель ВторойМакет и стат.метод all() (все)
        return $layout = SecondLayout::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SecondLayout $layout, $id)
    {
        return SecondLayout::destroy($id);
    }
}
