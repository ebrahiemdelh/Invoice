<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\Invoice_detail;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $details = Invoice_detail::where('id_Invoice', $id)->get();
        $invoice = invoices::where('id', $id)->first();
        $attachments  = invoice_attachment::where('id_Invoice',$id)->get();
        return view('invoices.invoice_details', compact('details', 'invoice','attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices=invoice_attachment::findorfail($request->id);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash("delete",'تم حذف الملف بنجاح');
        return back();
    }
    public function show_file($invoice_number,$filename) {
        $files=Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$filename);
        return response()->file($files);
    }
    public function get_file($invoice_number,$filename) {
        $contents=Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$filename);
        return response()->download($contents);
    }
}
