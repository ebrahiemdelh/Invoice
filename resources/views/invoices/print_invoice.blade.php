@extends('layouts.master')
@section('title')
طباعة الفاتورة
@endsection
@section('css')
    <style>
        @media print {
            #print_button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    طباعة الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id='print'>
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">تحصيل الفاتورة</h1>
                            <div class="billed-from">
                                <h6>ضلع سوفت.</h6>
                                <p>الحي البحري ,شبين الكوم ,المنوفية ,مصر<br>
                                    رقم الهاتف: 324 445-4544<br>
                                    للتواصل: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">معلومات الفاتورة</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span>
                                    <span>{{ $invoices->invoice_number }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الإصدار</span>
                                    <span>{{ $invoices->invoice_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الإستحقاق</span>
                                    <span>{{ $invoices->due_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <span>{{ $invoices->section->section_name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">المنتج</th>
                                        <th class="tx-center">مبلغ التحصيل</th>
                                        <th class="tx-right">مبلغ العمولة</th>
                                        <th class="tx-right">الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td class="tx-12">{{ $invoices->product }}</td>
                                        <td class="tx-center">{{ number_format($invoices->Amount_collection, 2) }}</td>
                                        <td class="tx-right">{{ number_format($invoices->Amount_commission, 2) }}</td>
                                        @php
                                            $total = $invoices->Amount_collection + $invoices->Amount_commission;
                                        @endphp
                                        <td class="tx-right">{{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">ملاحظات</label>
                                                <p>{{ $invoices->note }}</p>
                                            </div>
                                        </td>
                                        <td class="tx-right">الإجمالي</td>
                                        <td class="tx-right" colspan="2">{{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">نسبة الضريبة ({{ $invoices->rate_vat }})</td>
                                        <td class="tx-right" colspan="2">{{ number_format($invoices->value_vat, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">الخصم</td>
                                        <td class="tx-right" colspan="2">-{{ number_format($invoices->discount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">الإجمالي شامل الضريبة</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">{{ number_format($invoices->total, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">
                        <button id="print_button" class="btn btn-danger float-left mt-3 mr-2" onclick="printdiv()">
                            <i class="mdi mdi-printer ml-1"></i>طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@push('js')
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script>
        function printdiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents
            location.reload();
        }
    </script>
@endpush
