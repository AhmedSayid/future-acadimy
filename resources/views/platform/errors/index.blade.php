@extends('dashboard.layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المشاكل</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ المشاكل البرمجية</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">تاريخ المشاكل</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <button type="button"
                                class="reloadTable btn btn-outline-primary btn-block">
                            <i class="feather icon-refresh-cw"></i>تحديث</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive table_content_append">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="editErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editErrorForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="msg" class="form-label">Error</label>
                            <textarea name="msg" class="form-control" cols="20" rows="10" id="msg" disabled></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    @include('platform.layouts.get_data' , ['index_route' => url('platform/errors')])

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                let errorId = $(this).data('id');

                $.ajax({
                    url: `{{ route("errors.get-error-msg", '') }}/${errorId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.key === 'success') {
                            let error = response.data;
                            $('#editErrorModal').modal('show');
                            $('#editErrorForm [name="msg"]').val(error.message);
                        }
                    }
                });
            });
        });


    </script>
@endsection
