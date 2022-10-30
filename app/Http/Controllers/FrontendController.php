<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Order;
use App\Models\Orderditaile;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $hotproducts = Product::orderBy('created_at', 'desc')->take(6)->get();
        $products = Product::orderBy('created_at', 'desc')->get();
        $productCount = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get()->count();
        return view('frontend.home.index', [
            'categories'    => $categories,
            'hotproducts'   => $hotproducts,
            'products'      => $products,
            'productCount'      => $productCount,
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $product = new Cart();
        if (auth()->check()) {
            $product->user_id = auth()->user()->id;
        } else {
            $product->ip_address = $request->ip();
        }
        $product->product_id = $request->product_id;
        $product->qty = $request->qty ? $request->qty : 1;
        $product->price = $request->price;
        $product->save();
        return redirect()->back()->with('message', 'Products added  successfully.');
    }
    public function cartProducts()
    {
        $productCount = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get()->count();
        $products = Cart::with('products')->where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get();
        return view('frontend.cart.list', compact('productCount', 'products'));
    }
    public function deletecartProducts($id)
    {
        $Product = Cart::find($id);
        $Product->delete();
        return redirect()->back()->with('message', 'Product Deleted');
    }

    public function updatecartProducts(Request $request, $id)
    {

        $Product = Cart::find($id);
        $Product->update(
            [
                'qty' => $request->qty,
            ]

        );
        return redirect()->back()->with('message', 'Products qty update successfully.');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registrationuser()
    {
        $productCount = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get()->count();
        return view('frontend.auth.registration', compact('productCount'));
    }
    public function shipping()
    {
        $productCount = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get()->count();
        $products = Cart::with('products')->where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get();
        return view('frontend.auth.shipping', compact('productCount', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shippingStore(Request $request)

    {

        $billing = new Billing();
        $billing->user_id = auth()->user()->id;
        $billing->phone = $request->phone;
        $billing->address_one = $request->address_one;
        $billing->address_two = $request->address_two;
        $billing->country = $request->country;
        $billing->city = $request->city;
        $billing->state = $request->state;
        $billing->zip = $request->zip;
        $billing->payment_type = $request->payment_type;
        $billing->save();

        //Order table data insart

        if (!empty($billing)) {
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->total_qty = $request->total_qty;
            $order->total_price = $request->total_price;
            $order->save();


            //Orderditals table data insart

            //order_id	product_id	qty	price
            foreach ($request->product_id as $key => $product) {

                $orderditals = new Orderditaile();
                $orderditals->order_id =  $order->id;
                $orderditals->product_id = $request->product_id[$key];
                $orderditals->qty = $request->qty[$key];
                $orderditals->price = $request->price[$key];
                $orderditals->save();
            }
        }

        $Cartproducts = Cart::with('products')->where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get();
        foreach ($Cartproducts as $Cartproduct) {
            $Cartproduct->delete();
        }

        return redirect('/')->with('seccess', 'order complited');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function singleProduct($id)
    {
        $productdetal = Product::find($id);
        $productCount = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get()->count();
        return view('frontend.product.single', compact('productCount', 'productdetal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function searchProduct(Request $request)
    {
        $getSearchProducts = Product::orderBy('id', 'desc')->where('name', 'LIKE', '%' . $request->search . '%')->get();
        return $getSearchProducts;
    }
    public function allProductShop()
    {
        $productCount = Cart::where('user_id', auth()->check() ? auth()->user()->id : null)->orWhere('ip_address', request()->ip)->get()->count();
        return view('frontend.home.shop', compact('productCount'));
    }

    public function categories()
    {
        $categories = Category::get();
        return $categories;
    }

    public function brands()
    {
        $brands = Brand::get();
        return $brands;
    }

    public function products()
    {
        $products = Product::get();
        return $products;
    }

    public function productsFiltering(Request $request)
    {
        $products = Product::with('category', 'brand')->where(function ($cat) use ($request) {
            if ($request->category_id) {
                $cat->whereIn('category_id', $request->category_id);
            }
        })->where(function ($brand) use ($request) {
            if ($request->brand_id) {
                $brand->whereIn('brand_id', $request->brand_id);
            }
        })->get();
        return $products;
    }
}
