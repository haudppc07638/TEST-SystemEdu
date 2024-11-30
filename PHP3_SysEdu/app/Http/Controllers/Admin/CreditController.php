<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreditRequest;
use App\Models\Credit;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credit = Credit::getAllCredit();
        return view('admin.credits.index', [
            'creditView' => $credit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.credits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreditRequest $request) // Sử dụng CreditRequest
    {
        $data = $request->only(['price']);
        $data['vat'] = 0; // Đặt vat mặc định là 0
        $credit = Credit::createCredit($data);

        toastr()->success('Thêm thành công: ' . $credit->totalPrice);
        return redirect()->route('admin.credits.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $credit = Credit::getCreditID($id);
        return view('admin.credits.edit', ['credit' => $credit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreditRequest $request, string $id) // Sử dụng CreditRequest
    {
        $data = $request->only(['price']); // Bỏ vat
        $data['vat'] = 0; // Đặt vat mặc định là 0
        Credit::updateCredit($id, $data);
        toastr()->success('Cập nhật thành công ');
        return redirect()->route('admin.credits.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}