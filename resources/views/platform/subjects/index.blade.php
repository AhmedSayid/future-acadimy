@extends('dashboard.layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المواد</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">عرض المواد</span>
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
                        <h4 class="card-title mg-b-0">المواد</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-fall"
                           data-toggle="modal" href="#modaldemo8">إضافة مادة</a>
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

    <div class="modal" id="editSubjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editGradeForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل مادة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">الإسم</label>
                            <input type="text" name="name" class="form-control" id="editName" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="grade_id" class="form-label">الصف الدراسي</label>
                            <select class="form-control" name="grade_id" id="grade_id">
                                @foreach($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo8" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة مادة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="subjectForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">الإسم</label>
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="الإسم">
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="grade_id" class="form-label">الصف الدراسي</label>
                                <select class="form-control" name="grade_id" id="grade_id">
                                    @foreach($grades as $grade)
                                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary" id="saveUser">إضافة</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('platform.layouts.get_data', ['index_route' => url('platform/subjects/' . request()->segment(3))])

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                let userId = $(this).data('id');

                $.ajax({
                    url: `{{ route("subjects.get-subject-data", '') }}/${userId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.key === 'success') {
                            let grade = response.data;
                            $('#editSubjectModal').modal('show');
                            $('#editGradeForm [name="name"]').val(grade.name);
                            $('#editGradeForm [name="id"]').val(grade.id);
                            $('#editGradeForm [name="grade_id"]').val(grade.grade_id);
                        }
                    }
                });
            });

            $('#editGradeForm').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let subjectId = $('#editGradeForm [name="id"]').val();

                $.ajax({
                    url: `{{ route("subjects.update", '') }}/${subjectId}`,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.msg, 'نجاح');
                            $('#editSubjectModal').modal('hide');
                            $('.reloadTable').trigger('click');
                        }
                    }
                });
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let subjectId = $(this).data('id');

                if (confirm('هل أنت متأكد من حذف هذا الصف؟')) {
                    $.ajax({
                        url: `{{ route("subjects.delete", ":id") }}`.replace(':id', subjectId),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.key === 'success') {
                                toastr.success(response.msg, 'نجاح');
                                $('.reloadTable').trigger('click');
                            }
                        },
                        error: function (xhr) {
                            toastr.error('حدث خطأ ما. حاول مرة أخرى.', 'خطأ');
                        }
                    });
                }
            });

            $('#subjectForm').on('submit', function (e) {
                e.preventDefault();

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("subjects.store") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#saveSubject').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
                    },
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.message, 'نجاح', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500,
                            });

                            $('#modaldemo8').modal('hide');
                            $('#subjectForm')[0].reset();
                            $('.reloadTable').trigger('click');

                        } else {
                            toastr.error(response.message, 'خطأ', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500,
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                let input = $('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                            });
                        } else {
                            toastr.error('حدث خطأ ما. حاول مرة أخرى.', 'خطأ', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500,
                            });
                        }
                    },
                    complete: function () {
                        $('#saveSubject').html('إضافة').attr('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
