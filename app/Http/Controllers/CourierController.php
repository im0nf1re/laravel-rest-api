<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourierCollection;
use Illuminate\Http\Request;
use App\Models\Courier;
use App\Http\Resources\CourierResource;
use Illuminate\Http\Response;
use App\Enums\CourierType;
use Illuminate\Validation\Rules\Enum;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            'data' => ['required', 'array'],
            'data.*.courier_type' => ['required', new Enum(CourierType::class)],
            'data.*.regions' => ['required', 'array'],
            'data.*.regions.*' => 'integer',
            'data.*.working_hours' => ['required', 'array'],
            'data.*.working_hours.*' => 'string',
        ]);

        $couriers = [];
        foreach ($request->data as $item) {
            $courier = new Courier();
            $courier->courier_type = $item['courier_type'];
            $courier->save();
            $courier->regions()->attach($item['regions']);
            $courier->hours()->attach($item['working_hours']);

            $couriers[] = $courier;
        }
        return new Response(new CourierCollection($couriers), 201, ['description' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CourierResource(Courier::findOrFail($id));
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
        $request->validate([
            'courier_type' => new Enum(CourierType::class),
            'regions' => 'array',
            'regions.*' => 'integer',
            'working_hours' => 'array',
            'working_hours.*' => 'string',
        ]);

        $courier = Courier::findOrFail($id);
        $courier->courier_type = $request->courier_type;
        $courier->save();
        $courier->regions()->sync($request['regions']);
        $courier->hours()->sync($request['working_hours']);

        return new Response(new CourierResource($courier), 200, ['description' => 'Created']);
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
