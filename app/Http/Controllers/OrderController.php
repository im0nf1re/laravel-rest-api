<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Http\Response;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'data.*.weight' => ['required', 'numeric'],
            'data.*.region' => ['required', 'integer'],
            'data.*.delivery_hours' => ['required', 'array'],
            'data.*.delivery_hours.*' => 'string'
        ]);

        $orders = [];
        foreach ($request->data as $item) {
            $order = new Order();
            $order->weight = $item['weight'];
            $order->region_id = $item['region'];
            $order->save();
            $order->hours()->attach($item['delivery_hours']);

            $orders[] = $order;
        }
        return new Response(new OrderCollection($orders), 201, ['description' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Assign orders to a courier by id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function assign(Request $request)
    {
        $request->validate([
            'courier_id' => ['required', 'integer'],
        ]);

        $orders = Order::where('courier_id', null)->get();
        $now = now();
        foreach ($orders as $order) {
            $order->courier_id = $request->courier_id;
            $order->assign_time = $now;
            $order->save();
        }
        return ['orders' => OrderResource::collection($orders), 'assign_time' => $now];
    }

    /**
     * Marks orders as completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function complete(Request $request)
    {
        $request->validate([
            'courier_id' => ['required', 'integer'],
            'order_id' => ['required', 'integer'],
            'complete_time' => ['required', 'date']
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->complete_time = new \DateTime($request->complete_time);
        $order->save();
        return ['order_id' => $order->id];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
