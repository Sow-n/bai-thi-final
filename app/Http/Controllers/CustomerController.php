<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $listCustomer = CustomerModel::where('name', 'like', "%$search%")
            ->orwhere('phone', 'like', "%$search%")->paginate(10);

        return view(
            'customers.index',
            compact($listCustomer),
            [
                'search' => $search,
                'listCustomer' => $listCustomer
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2',
            'phone' => 'required',
            'email' => 'required|unique:customer',
            'image' => 'required'
        ], [
            'email.required' => "Email không được để trống",
            'email.unique' => "Email đã tồn tại",
            'phone.required' => "Số điện thoại không được để trống",
            'image.required' => "Ảnh chưa có mục được chọn",
            'name.required' => "Tên không được để trống",
            'name.min' => "Tên không được nhỏ hơn 2 ký tự",
        ]);

        $name = $request->get('name');
        $email = $request->get('email');
        $gender = $request->get('gender');
        $phone = $request->get('phone');
        $image = $request->file('image');
        $newImageName = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $newImageName);

        $customer = new CustomerModel();
        $customer->name = $name;
        $customer->email = $email;
        $customer->gender = $gender;
        $customer->phone = $phone;
        $customer->image_path = $newImageName;
        $customer->save();
        return Redirect::route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
