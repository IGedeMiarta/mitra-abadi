<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Media;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\SpecialProduct;
use App\Models\Testimony;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $data['title'] = '';
        $data['category_all'] = Categories::limit(10)->get();
        $data['product_all'] = Product::with(['category','brand'])->where('status',1)->orderByDesc('id')->limit(20)->get();
        $data['special'] = ProductDiscount::with('product')->orderByDesc('id')->where('status',1)->limit(10)->get();
        $data['testi']  =Testimony::with('user')->orderByDesc('id')->limit(10)->get();
        return view('home.main',$data);
    }
    public function profileUpdate(Request $request,$id){
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->back()->with('success','Profile Update');
    }

    public function product(Request $request,$slug){
        $data['title'] = 'Product';
        // dd($request->all());
        $product = Product::with('brand')->where('product_slug',$slug)->first();
        if($request->special){
            $special = ProductDiscount::where('id_product',$product->id)->first();
            if(!$special){
                $data['price'] = $product->price;
                $data['disc'] = false;
            }else{
                $data['price'] = $special->final_amount;
                $data['disc'] = $product->price;
            }
           
        }else{
            $data['price'] = $product->price;
            $data['disc'] = false;
        }
        $details = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $product->description);
        $details = nl2br($details);
        $data['product'] = $product;
        $data['details'] = $details;
        $data['related'] = Product::where('id_category',$product->id_category)->whereNot('id',$product->id)->limit(5)->orderByDesc('id')->get();
        // dd($data);
        return view('home.product',$data);
    }
    public function catalog(Request $request){
        $data['title'] = 'Catalog';
        $data['catalog'] = Product::with('category','brand')->paginate(4);
        if($request->search){
            $data['catalog'] = Product::with('category','brand')->where('product_name','LIKE','%'.$request->search.'%')->paginate(4);
            $data['title'] = 'Catalog Search : '. $request->search;
        }
        if($request->category){
            $catagory = Categories::where('category_slug',$request->category)->first();
            $data['catalog'] = Product::with('category','brand')->where('id_category',$catagory->id)->paginate(4);
            $data['title'] = 'Catalog : '. $catagory->category_name;
        }
        if($request->search && $request->category){
            $catagory = Categories::where('category_slug',$request->category)->first();
            $data['catalog'] = Product::with('category','brand')
            ->where('id_category',$catagory->id)
            ->where('product_name','LIKE','%'.$request->search.'%')
            ->paginate(4);
            $data['title'] = 'Catalog : '. $catagory->category_name;
        }
        if($request->brand){
            $brand = Brand::find($request->brand);
            $data['title'] = 'Brand: '. $brand->name;
            $data['catalog'] = Product::with('category','brand')->where('brand_id',$request->brand)->paginate(4);
        }
        $data['related'] = Product::limit(5)->orderByDesc('id')->paginate(5);
        return view('home.catalog',$data);
    }
    public function specialCatalog(Request $request){
        $data['title'] = 'Special OFFER';
        $data['catalog'] = ProductDiscount::with('product','product.category','product.brand')->paginate(4);
        // dd($data);
        
        $data['related'] = Product::limit(5)->orderByDesc('id')->paginate(5);
        return view('home.special-catalog',$data);
    }
    public function profile(){
        $data['title'] = 'Profile';
        $data['user']   = Auth::user();
        $data['table'] = Transaction::with('details','details.product')->where('customer',auth()->user()->id)->orderBy('status','ASC')->orderBy('id','desc')->limit(5)->get();


        return view('home.profile',$data);
    }
}
