<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceProduct;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoice = Invoice::orderby('created_at','desc')->get();

        return view('invoices.index',['invoices'=>$invoice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'invoice_no'=>'required|alpha_dash|unique:invoices',
            'client'=>'required|max:255',
            'client_address'=>'required|max:255',
            'invoice_date'=>'required',
            'due_date'=>'required',
            'title'=>'required|max:255',
            'discount'=>'required|min:0|numeric',
            'products.*.name'=>'required|max:255',
            'products.*.price'=>'required|numeric|min:1',
            'products.*.qty'=>'required|integer|min:1'
        ]);


        $products = collect($request->products)->transform(function($product){
            $product['total']=$product['qty']*$product['price'];
            return new InvoiceProduct($product);
        });


        /*if($products->isEmpty()){
            return response()->json(['products_empty'=>'You need add one more product.'],422);
        }*/

        $data = $request->except('products');
        $data['sub_total']=$products->sum('total');
        $data['grand_total']=$data['sub_total']-$data['discount'];

        $invoice = Invoice::create($data);

        $invoice->products()->saveMany($products);

        return response()->json([
            'created'=>true,
            'id'=>$invoice->id
        ]);

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
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('invoices.show',['invoice'=>$invoice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('invoices.edit',['invoice'=>$invoice]);
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
        //
        $this->validate($request,[
            'invoice_no'=>'required|alpha_dash|unique:invoices,invoice_no,'.$id.',id',
            'client'=>'required|max:255',
            'client_address'=>'required|max:255',
            'invoice_date'=>'required',
            'due_date'=>'required',
            'title'=>'required|max:255',
            'discount'=>'required|min:0|numeric',
            'products.*.name'=>'required|max:255',
            'products.*.price'=>'required|numeric|min:1',
            'products.*.qty'=>'required|integer|min:1'
        ]);

        $invoice = Invoice::findOrFail($id);
        $products = collect($request->products)->transform(function($product){
            $product['total']=$product['qty']*$product['price'];
            return new InvoiceProduct($product);
        });




        /*if($products->isEmpty()){
            return response()->json(['products_empty'=>'You need add one more product.'],422);
        }*/

        $data = $request->except('products');
        $data['sub_total']=$products->sum('total');
        $data['grand_total']=$data['sub_total']-$data['discount'];

        $invoice->update($data);

        //remove old product and attach new ones

        InvoiceProduct::where('invoice_id',$invoice->id)->delete();


        //update  it with new
        $invoice->products()->saveMany($products);

        return response()->json([
            'update'=>true,
            'id'=>$invoice->id
        ]);

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
        Invoice::findOrFail($id)->delete();
        InvoiceProduct::where('invoice_id',$id)->delete();
        return redirect('invoices');
    }
}
