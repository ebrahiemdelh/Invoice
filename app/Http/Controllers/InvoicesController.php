<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\Invoice_detail;
use App\Models\invoices;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required | unique:invoices,invoice_number',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'product' => 'required',
            'section' => 'required',
            'Amount_collection' => 'required',
            'Amount_commission' => 'required',
            'discount' => 'required',
            'rate_vat' => 'required',
        ], [
            'invoice_number.required' => 'يجب إدخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة مسجل بالفعل',
            'invoice_date.required' => 'يجب إدخال تاريخ الفاتورة',
            'due_date.required' => 'يجب إدخال تاريخ الإستحقاق',
            'product.required' => 'يجب إدخال اسم المنتج',
            'section.required' => 'يجب إدخال اسم القسم',
            'Amount_collection.required' => 'يجب إدخال مبلغ التحصيل',
            'Amount_commission.required' => 'يجب إدخال مبلغ العمولة',
            'discount.required' => 'يجب إدخال قيمة الخصم',
            'rate_vat.required' => 'يجب إدخال نسبة القيمة المضافة',
        ]);

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'Amount_collection' => $request->Amount_collection,
            'Amount_commission' => $request->Amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
        ]);

        $id_Invoice = invoices::latest()->first()->id;
        Invoice_detail::create([
            'id_Invoice' => $id_Invoice,
            'invoice_number' => $request->invoice_number,
            'section' => $request->section,
            'product' => $request->product,
            'note' => $request->note,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'user' => (Auth::user()->name)
        ]);
        if ($request->hasFile('pic')) {
            $id_Invoice = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->id_Invoice = $id_Invoice;
            $attachments->save();

            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        session()->flash('Add', 'تم إضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($value_status)
    {
        $invoices=invoices::where("value_status",$value_status)->get();
        if($value_status===1){
            return view('invoices.invoices_paid',compact('invoices'));
        }
        elseif($value_status===2){
            return view('invoices.invoices_unpaid',compact('invoices'));
        }
        else{
            return view('invoices.invoices_partially_paid',compact('invoices'));
        }
    }

    public function print($id) {
        $invoices=invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required | unique:invoices,invoice_number,' . $request->invoice_id,
            'invoice_date' => 'required',
            'due_date' => 'required',
            'product' => 'required',
            'section' => 'required',
            'Amount_collection' => 'required',
            'Amount_commission' => 'required',
            'discount' => 'required',
            'rate_vat' => 'required',
        ], [
            'invoice_number.required' => 'يجب إدخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة مسجل بالفعل',
            'invoice_date.required' => 'يجب إدخال تاريخ الفاتورة',
            'due_date.required' => 'يجب إدخال تاريخ الإستحقاق',
            'product.required' => 'يجب إدخال اسم المنتج',
            'section.required' => 'يجب إدخال اسم القسم',
            'Amount_collection.required' => 'يجب إدخال مبلغ التحصيل',
            'Amount_commission.required' => 'يجب إدخال مبلغ العمولة',
            'discount.required' => 'يجب إدخال قيمة الخصم',
            'rate_vat.required' => 'يجب إدخال نسبة القيمة المضافة',
        ]);
        // $invoices=invoices::where('id',$request->invoice_id)->first();
        invoices::where('id', $request->invoice_id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_commission' => $request->Amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'تم تعديل البيانات بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoices::where('id', $request->invoice_id)->first();
        $details = invoice_attachment::where("id_Invoice", $request->invoice_id)->first();
        if (!empty($details->invoice_number)) {
            // Storage::disk('public_uploads')->delete($details->invoice_number . '/' . $details->file_name);
            Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
        }
        $invoices->forceDelete();
        session()->flash('delete_invoice', 'تم حذف الفاتورة');
        return redirect('/invoices');
    }
    public function getproducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function status_show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view("invoices.status_show", compact('invoices'));
    }

    public function status_update(Request $request, $id)
    {
        $invoices = invoices::findorfail($id);
        if ($request->status === 'مدفوعة') {
            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);
            Invoice_detail::create([
                'invoice_number' => $request->invoice_number,
                'id_Invoice' => $request->invoice_id,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'value_status' => 1,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);
            Invoice_detail::create([
                'invoice_number' => $request->invoice_number,
                'id_Invoice' => $request->invoice_id,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'value_status' => 3,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update', 'تم تحديث البيانات بنجاح');
        return redirect('/invoices');
    }
}
