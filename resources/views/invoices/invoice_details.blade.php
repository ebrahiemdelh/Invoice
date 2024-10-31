@extends('layouts.master')
@section('title')
    تفاصيل العملية
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="basic-alert">
                <div class="col-xl-12">
                    <!-- div -->
                    <div class="card mg-b-20 border-0" id="tabs-style3">
                        <div class="card-body">
                            <div class="main-content-label mg-b-5">تفاصيل الفاتورة</div>
                            <div class="text-wrap">
                                <div class="example border-0">
                                    <div class="panel panel-primary tabs-style-3">
                                        <div class="tab-menu-heading">
                                            <div class="tabs-menu ">
                                                <!-- Tabs -->
                                                <ul class="nav panel-tabs">
                                                    <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                                class="fa fa-laptop"></i> معلومات الفاتورة</a></li>
                                                    <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i>
                                                            العمليات على الفاتورة</a></li>
                                                    <li><a href="#tab14" data-toggle="tab"><i class="fa fa-tasks">
                                                                المرفقات</i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body tabs-menu-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab11">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td>رقم الفاتورة</td>
                                                                <td>{{ $invoice->invoice_number }}</td>
                                                                <td>تاريخ الفاتورة</td>
                                                                <td>{{ $invoice->invoice_date }}</td>
                                                                <td>تاريخ الإستحقاق</td>
                                                                <td>{{ $invoice->due_date }}</td>
                                                                <td>القسم</td>
                                                                <td>{{ $invoice->section->section_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>المنتج</td>
                                                                <td>{{ $invoice->product }}</td>
                                                                <td>مبلغ التحصيل</td>
                                                                <td>{{ $invoice->Amount_collection }}</td>
                                                                <td>مبلغ العمولة</td>
                                                                <td>{{ $invoice->Amount_commission }}</td>
                                                                <td>الخصم</td>
                                                                <td>{{ $invoice->discount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>نسبة الضريبة</td>
                                                                <td>{{ $invoice->rate_vat }}</td>
                                                                <td>قيمة الضريبة</td>
                                                                <td>{{ $invoice->value_vat }}</td>
                                                                <td>الإجمالي مع الضريبة</td>
                                                                <td>{{ $invoice->total }}</td>
                                                                <td>الحالة الحالية</td>
                                                                <td>
                                                                    @if ($invoice->value_status == 1)
                                                                        <span
                                                                            class="text-white bg-success py-1 px-3 rounded-pill">{{ $invoice->status }}</span>
                                                                    @elseif($invoice->value_status == 2)
                                                                        <span
                                                                            class="text-white bg-danger py-1 px-3 rounded-pill">{{ $invoice->status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-white bg-warning py-1 px-3 rounded-pill">{{ $invoice->status }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>المستخدم</td>
                                                                @foreach ($details as $detail)
                                                                    <td>{{ $detail->user }}</td>
                                                                @endforeach
                                                                <td>ملاحظات</td>
                                                                <td>{{ $invoice->note }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tab12">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <td>#</td>
                                                            <td>رقم الفاتورة</td>
                                                            <td>نوع المنتج</td>
                                                            <td>القسم</td>
                                                            <td>حالة الدفع</td>
                                                            <td>تاريخ الدفع</td>
                                                            <td>ملاحظات</td>
                                                            <td>تاريخ الإضافة</td>
                                                            <td>المستخدم</td>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($details as $detail)
                                                                <tr>
                                                                    <td>{{ ++$i }}</td>
                                                                    <td>{{ $detail->invoice_number }}</td>
                                                                    <td>{{ $detail->product }}</td>
                                                                    <td>{{ $invoice->section->section_name }}</td>
                                                                    <td>
                                                                        @if ($detail->value_status == 1)
                                                                            <span
                                                                                class="text-white bg-success py-1 px-3 rounded-pill">{{ $detail->status }}</span>
                                                                        @elseif($detail->value_status == 2)
                                                                            <span
                                                                                class="text-white bg-danger py-1 px-3 rounded-pill">{{ $detail->status }}</span>
                                                                        @else
                                                                            <span
                                                                                class="text-white bg-warning py-1 px-3 rounded-pill">{{ $detail->status }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td></td>
                                                                    </td>
                                                                    <td>{{ $detail->note }}</td>
                                                                    <td>{{ $detail->created_at }}</td>
                                                                    <td>{{ $detail->user }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tab14">
                                                    <div class="card card-statistics">
                                                        <div class="card-body">
                                                            <p class="text-danger">* صيغة المرفق pdf, jpeg, jpg, png</p>
                                                            <h5>إضافة مرفقات</h5>
                                                            <form action="{{ url('/invoiceAttachments') }}" method="post"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="customFile" name="file_name" required>
                                                                    <input type="hidden" name="invoice_number"
                                                                        id="customFile"
                                                                        value="{{ $invoice->invoice_number }}">
                                                                    <input type="hidden" name="id" id="customFile"
                                                                        value="{{ $invoice->id }}">
                                                                    <label for="customFile" class="custom-file-label">حدد
                                                                        المرفق</label>
                                                                </div><br><br>
                                                                <button type="submit" class="btn btn-primary btn-sm"
                                                                    name="uploadFile">تأكيد</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive mt-15">
                                                        <table
                                                            class="table center-aligned-table mb-0 table table-hover text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th>م</th>
                                                                    <th>اسم الملف</th>
                                                                    <th>قام بالإضافة</th>
                                                                    <th>تاريخ الإضافة</th>
                                                                    <th>العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 0; ?>
                                                                @foreach ($attachments as $attachment)
                                                                    <tr>
                                                                        <td>{{ ++$i }}</td>
                                                                        <td>{{ $attachment->file_name }}</td>
                                                                        <td>{{ $attachment->created_by }}</td>
                                                                        <td>{{ $attachment->created_at }}</td>
                                                                        <td colspan="2">
                                                                            <a href="{{ url('view_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                class="btn btn-outline-success btn-sm"
                                                                                role="button"><i class="fas fa-eye">
                                                                                    عرض</i></a>
                                                                            <a href="{{ url('download') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                class="btn btn-outline-info btn-sm"
                                                                                role="button"><i class="fas fa-download">
                                                                                    تحميل</i></a>
                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name='{{ $attachment->file_name }}'
                                                                                data-invoice_number='{{ $attachment->invoice_number }}'
                                                                                data-id='{{ $attachment->id }}'
                                                                                data-target='#delete_file'><i
                                                                                    class="fas fa-trash"> حذف</i></button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_file') }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- main-content closed -->
@endsection
@push('js')
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endpush
