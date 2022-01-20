<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirstLayoutRequest;
use App\Http\Resources\FirstLayoutResources;
use App\Models\FirstLayout;
use Illuminate\Http\Request;


class FirstLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return FirstLayout[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return $layout = FirstLayout::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return FirstLayoutResources
     */
    public function store(FirstLayoutRequest $request)
    {
        return FirstLayout::create($request->all());

//        try {
//            // используй такой синтаксис
//            $layout = new FirstLayout($request->all());
//            // сохраняй
//            $layout->save();
////            $created_item = FirstLayout::create($request->all());
//        } catch(\Exception $error) {
//           return response($error->getMessage());
//        }
////        return new FirstLayoutResources($created_item);
//        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return FirstLayoutResources
     */
    public function show($id)
    {
//        return new FirstLayoutResources(FirstLayout::with('lists')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return FirstLayoutResources
     */
    public function update(Request $request, FirstLayout $layout, $id)
    {
        // $table - создал переменную, которая находит конкретный стол по модели FirstLayout
        // Использую стат.метод finOrFail, куда передаю $id
        // В этой переменной использую метод update
        // В update помещаю весь $request, в котором выбираю all();
        $table = FirstLayout::findOrFail($id);
        $table->update($request->all());

        // Возвращаю Макет - модель ПервыйМакет и стат.метод all() (все)
        return $layout = FirstLayout::all();

        //  return new FirstLayoutResources($layout);
        //  $layout = new FirstLayout();
        //  $layout = $request;
        //  $layout->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FirstLayout $layout, $id)
    {
//        $layout->delete();
//        return response(null);
        return FirstLayout::destroy($id);
    }
}
