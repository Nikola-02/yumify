<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\throwException;

class OrderController extends OsnovniController
{
    public function index(){
        return view('pages.order.index');
    }

    public function apiOrderCartIndex(){
        $notSold = 0;
        $activeOrderForLoggedUser = Order::where('user_id', session()->get('user')->id)->where('is_ordered', $notSold)->first();
        if($activeOrderForLoggedUser){
            return response()->json($activeOrderForLoggedUser->orderLines()->with('meal', 'meal.restaurant')->get());
        }else{
            return response()->json([]);
        }

    }

    public function storeMealInOrder(Request $request){
        if(isset($request->meal_id)){
            $meal = Meal::find($request->meal_id);

            if($meal ?? false){
                $notSold = 0;
                $orderForLoggedUser = Order::where('user_id', session()->get('user')->id)->where('is_ordered', $notSold)->first();

                if($orderForLoggedUser){

                    $orderLineWithSpecificMealAlreadyInOrder = $orderForLoggedUser->orderLines()->where('meal_id', $request->meal_id)->first();

                    if($orderLineWithSpecificMealAlreadyInOrder){
                        //Taj specifican meal vec postoji u aktivnom orderu ulogovanog korisnika, POVECAJ QUANTITY

                        $current_quantity = $orderLineWithSpecificMealAlreadyInOrder->quantity;

                        try {
                            $orderLineWithSpecificMealAlreadyInOrder->update([
                                'quantity'=>$current_quantity + 1
                            ]);

                            $this->log_action_for_user('Updated quantity of item.');

                            return response()->json(['message'=>'Successfully updated quantity of item.']);
                        }catch (\Exception $ex){
                            return response()->json($ex->getMessage());
                        }

                    }else{
                        //Taj specifican meal NE postoji u aktivnom orderu ulogovanog korisnika
                        try {
                            $orderForLoggedUser->orderLines()->create([
                                'meal_id'=>$request->meal_id,
                                'quantity' => 1
                            ]);

                            $this->log_action_for_user('Added item to cart.');

                            return response()->json(['message'=>'Successfully added to cart.']);
                        }catch (\Exception $ex){
                            return response()->json($ex->getMessage());
                        }

                    }


                }else{
                    //Aktivan order za logovanog usera NE postoji
                    $order_fields = [
                        'user_id'=>session()->get('user')->id,
                        'is_ordered'=>$notSold
                    ];

                    try {
                        $order = Order::create($order_fields);
                        $order->orderLines()->create([
                            'meal_id' => $request->meal_id,
                            'quantity' => 1
                        ]);

                        $this->log_action_for_user('Added item to cart.');

                        return response()->json(['message'=>'Successfully added to cart.']);
                    }catch (\Exception $ex){
                        return response()->json($ex->getMessage());
                    }
                }
            }else{
                return response()->json(['message'=>'Bad request params.'], 400);
            }
        }else{
            return response()->json(['message'=>'Bad request params.'], 400);
        }
    }

    public function updateQuantityOfOrderLine(OrderLine $orderLine, Request $request){
        $request->validate([
            'quantity'=>'required|gt:0'
        ]);

        try {
            $orderLine->update([
                'quantity'=>$request->quantity
            ]);

            $this->log_action_for_user('Updated quantity of item.');

            return $this->apiOrderCartIndex();
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }

    public function deleteItemFromOrder(OrderLine $orderLine, Request $request){
        try {
            $orderLine->delete();

            $this->log_action_for_user('Removed item from order.');

            return $this->apiOrderCartIndex();
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }

    public function orderCartNow(Request $request){
        $sold = 1;
        $notSold = 0;
        $request->validate([
            'location'=>'required',
        ]);

        try {
            $orderForLoggedUser = Order::where('user_id', session()->get('user')->id)->where('is_ordered', $notSold)->first();

            $orderLines = $orderForLoggedUser->orderLines()->with('meal')->get();

            $total_price = 0;
            $delivery_price = 0.50;

            foreach ($orderLines as $line){
                $total_price += $line->meal->trigger_price * $line->quantity;
            }

            $total_price += $delivery_price;

            $orderForLoggedUser->update([
                'total_price'=>round($total_price, 2),
                'is_ordered'=>$sold,
                'ordered_on_location'=>$request->location
            ]);

            //Return items of order

            $items = Order::where('user_id', session()->get('user')->id)->where('is_ordered', $notSold)->first();

            if ($items == null) {
                $items = [];
            } else {
                throw new \Exception('Neuspesno porucivanje.');
            }

            $this->log_action_for_user('Cart ordered.');

            return response()->json([
                'message' => 'Successfully ordered. Thanks!',
                'items' => $items
            ]);

        }catch (\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }

    public function orderHistoryIndex(){
        return view('pages.order.history', [
                'orders'=>Order::with('orderLines', 'orderLines.meal', 'user')->where('user_id', session()->get('user')->id)->where('is_ordered', 1)->get()
        ]);
    }

}
