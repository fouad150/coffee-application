<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dishes = Dish::latest()->paginate(6);
        // $dishes = Dish::where('column_name', 'value')->get();//this request get from the database the record were column_name=value
        $dishes = Dish::all();
        return view('dishes.index', compact('dishes'));
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function showMenu()
    {
        $dishes = Dish::all();
        return view('dishes.menu', compact('dishes'));
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);

        // Dish::create($request->all()); //create is look like the save function
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('assets/img/menu/'), $imageName);

        $dish->image = $imageName;
        $dish->name = $request->name;
        $dish->description = $request->description;
        $dish->price = $request->price;
        $dish->save();

        return redirect()->route('dishes.index')
            ->with('success', 'The dish created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        return view('dishes.show', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        return view('dishes.edit', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
        // $dish->update($request->all());
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('assets/img/menu/'), $imageName);
        Dish::where('id', $dish->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageName,
        ]);

        return redirect()->route('dishes.index')
            ->with('success', 'The dish updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();

        return redirect()->route('dishes.index')
            ->with('success', 'The dish deleted successfully');
    }
}
