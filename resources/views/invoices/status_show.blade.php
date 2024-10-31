@extends('layouts.master')
@section('title')
    حالة الدفع
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تغير حالة
                    الدفع</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('status_update', ['id' => $invoices->id]) }}" method="post" autocomplete="off">
                        @method('put')
                        @csrf
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="invoice_number" class="control-label">رقم الفاتورة</label>
                                <input type="hidden" name="invoice_id" value="{{ $invoices->id }}">
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" value="{{ $invoices->invoice_number }}" required
                                    readonly>
                            </div>
                            <div class="col">
                                <label for="invoice_date">تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" id="invoice_date" name="invoice_Date"
                                    placeholder="YYYY-MM-DD" type="text" value="{{ $invoices->invoice_date }}" required
                                    readonly>
                            </div>
                            <div class="col">
                                <label for="due_date">تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" id="due_date" name="Due_date"
                                    placeholder="YYYY-MM-DD" type="text" value="{{ $invoices->due_date }}" required
                                    readonly>
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="section" class="control-label">القسم</label>
                                <select id="section" name="section" class="form-control SlectBox"
                                    onclick="console.log($(this).val())" onchange="console.log('change is firing')"
                                    readonly>
                                    <!--placeholder-->
                                    <option value=" {{ $invoices->section->id }}">
                                        {{ $invoices->section->section_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="product" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control" readonly>
                                    <option value="{{ $invoices->product }}"> {{ $invoices->product }}</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="Amount_collection" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="Amount_collection" name="Amount_collection"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{ $invoices->Amount_collection }}" readonly>
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div class="row">
                            <div class="col">
                                <label for="Amount_commission" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_commission"
                                    name="Amount_commission"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{ $invoices->Amount_commission }}" required readonly>
                            </div>
                            <div class="col">
                                <label for="discount" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{ $invoices->discount }}" required readonly>
                            </div>
                            <div class="col">
                                <label for="rate_vat" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()"
                                    readonly>
                                    <!--placeholder-->
                                    <option value=" {{ $invoices->rate_vat }}">
                                        {{ $invoices->rate_vat }}
                                </select>
                            </div>
                        </div>
                        {{-- 4 --}}
                        <div class="row">
                            <div class="col">
                                <label for="value_vat" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat"
                                    value="{{ $invoices->value_vat }}" readonly>
                            </div>
                            <div class="col">
                                <label for="total" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly
                                    value="{{ $invoices->total }}">
                            </div>
                        </div>
                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="note">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="3" readonly>
                                {{ $invoices->note }}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <label for="status">حالة الدفع</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option selected="true" disabled="disabled">-- حدد حالة الدفع --</option>
                                    <option value="مدفوعة">مدفوعة</option>
                                    <option value="مدفوعة جزئيا">مدفوعة جزئيا</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="payment_date">تاريخ الدفع</label>
                                <input class="form-control fc-datepicker" id="payment_date" name="payment_date" placeholder="YYYY-MM-DD"
                                    type="text" required>
                            </div>
                        </div><br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تحديث حالة الدفع</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@push('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
@endpush
