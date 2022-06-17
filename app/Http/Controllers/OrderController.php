<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        
    }

    public function getOrders() {
        $orders = Order::all()->sortBy('id');

        
        return view ('order.orders' , [
            'orders' => $orders

        ]);
    }

    

    
  
    
    
    
}
