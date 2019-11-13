<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Product;

class ProductController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'p_name' => ['required', 'string', 'max:255'],
            'p_code' => ['required', 'string',  'max:255', 'unique:products'],
            'p_price' => ['required'],
            'p_status' =>['required']
        ]);
        
        return Product::create([
            'p_name' => $request['p_name'],
            'p_code' => $request['p_code'],
            'p_sku' => $request['p_sku'],
            'p_unit' => $request['p_unit'],
            'p_price' => $request['p_price'],
            'p_status' => $request['p_status'],
            'p_photo' => $request['p_photo'],
        ]);
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required| string| email| max:191| unique:users,email,'.$user->id,
            'password' => 'sometimes',

            
        ]);

        $currentPhoto = $user->photo;


        if($request->photo != $currentPhoto){

            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                unlink($userPhoto);
            }
        }
        if(!empty($request->password)){
            $request->merge(['password'=> Hash::make($request['password'])]);
        }

        $user->update($request->all());
       // return ['message'=>'profile update'];
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $product;
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
        $product = Product::findOrFail($id);

        $this->validate($request,[
            'p_name' => ['required', 'string', 'max:255'],
            'p_code' => 'required', 'string',  'max:255', 'unique:products,p_code'.$product->id,
            'p_price' => ['required'],
            'p_status' =>['required']
            
        ]);

        $product->update($request->all());

        return ['message'=>'Update Product info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = Product::findOrFail($id);

        $user->delete();

        return ['message'=>'Product deleted'];
    }
}
