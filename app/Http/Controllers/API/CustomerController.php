<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Customer;

class CustomerController extends Controller
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
        return Customer::latest()->paginate(10);
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string',  'max:255', 'unique:customers'],
            'credit_limit' => ['required'],
            'c_status' =>['required']
        ]);
        
        return Customer::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'credit_limit' => $request['credit_limit'],
            'address' => $request['address'],
            'c_status' => $request['c_status'],
            'c_photo' => $request['c_photo'],
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
        $product = Customer::findOrFail($id);
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
        $customer = Customer::findOrFail($id);

        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'phone' => 'required', 'string',  'max:255', 'unique:customers,phone'.$customer->id,
            'credit_limit' => ['required'],
            'c_status' =>['required']
            
        ]);

        $product->update($request->all());

        return ['message'=>'Update Customer info'];
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
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return ['message'=>'Customer deleted'];
    }
}
