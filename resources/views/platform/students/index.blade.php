@extends('dashboard.layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الطلاب</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">عرض الطلاب</span>
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
                        <h4 class="card-title mg-b-0">الطلاب</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-fall"
                           data-toggle="modal" href="#modaldemo8">إضافة طالب</a>
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

    <div class="modal" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editUserForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل طالب</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">الإسم</label>
                            <input type="text" name="name" class="form-control" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">الهاتف</label>
                            <input type="text" name="phone" class="form-control" id="editPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="password">كلمة المرور</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="كلمة المرور">
                        </div>
                        <div class="form-group">
                            <label for="grade">الصف الدراسي</label>
                            <select name="grade_id" id="editGrade" class="form-control">
                                <option value="">اختر الصف الدراسي</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subject">المادة</label>
                            <select class="form-control select2" name="subject_id[]" id="editSubject" style="width: 100%"
                                    multiple="multiple">
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
                    <h6 class="modal-title">إضافة طالب</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="userForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">الإسم</label>
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="الإسم">
                        </div>
                        <div class="form-group">
                            <label for="phone">رقم الهاتف</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="الهاتف">
                        </div>
                        <div class="form-group">
                            <label for="password">كلمة المرور</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="كلمة المرور">
                        </div>
                        <div class="form-group">
                            <label for="grade">الصف الدراسي</label>
                            <select name="grade_id" id="grade" class="form-control">
                                <option value="">اختر الصف الدراسي</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subject">المادة</label>
                            <select class="form-control select2" name="subject_id[]" id="subject" style="width: 100%"
                                    multiple="multiple">
                            </select>
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
    @include('platform.layouts.get_data' , ['index_route' => url('platform/students')])

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                let userId = $(this).data('id');

                $.ajax({
                    url: `{{ route("students.get-student-data", '') }}/${userId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.key === 'success') {
                            let user = response.data.user;
                            let gradeId = response.data.grade.id;
                            let subjectIds = response.data.subject_id; // Array of selected subject IDs

                            $('#editUserModal').modal('show');

                            // Set user details
                            $('#editUserForm [name="name"]').val(user.name);
                            $('#editUserForm [name="phone"]').val(user.phone);
                            $('#editUserForm [name="id"]').val(user.id);

                            // Set selected grade
                            $('#editGrade').val(gradeId).trigger('change');

                            // Wait for the select2 dropdown to be initialized
                            setTimeout(() => {
                                $('#editSubject').val(subjectIds).trigger('change');
                            }, 500);
                        }
                    }
                });
            });

            $('#editUserForm').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let userId = $('#editUserForm [name="id"]').val();

                $.ajax({
                    url: `{{ route("students.update", '') }}/${userId}`,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.msg, 'نجاح');
                            $('#editUserModal').modal('hide');
                            $('.reloadTable').trigger('click');
                        }
                    }
                });
            });

            $(document).on('click', '.change_status', function (e) {
                e.preventDefault();
                let button = $(this);
                $.ajax({
                    url: '{{route("students.change-status")}}',
                    method: 'get',
                    data: {id: button.data('id')},
                    dataType: 'json',
                    beforeSend: function () {
                        button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
                    },
                    success: function (response) {
                        toastr.success(response.msg, @json('تم تغيير حالة المستخدم بنجاح'), {
                            closeButton: false,
                            progressBar: false,
                            positionClass: 'toast-top-right',
                            timeOut: '1500',
                        });
                        setTimeout(function () {
                            $('.reloadTable').trigger('click');
                        }, 1500);
                    },
                    fail: function (response) {
                        toastr.fail(response.msg, @json('حدث خطأ ما'), {
                            closeButton: false,
                            progressBar: false,
                            positionClass: 'toast-top-right',
                            timeOut: '1500',
                        });

                    },
                });
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let userId = $(this).data('id');

                if (confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
                    $.ajax({
                        url: `{{ route("students.delete", ["id" => ":id"]) }}`
                            .replace(':id', userId),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
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

            $(document).on('click', '.btn-logout', function (e) {
                e.preventDefault();
                let userId = $(this).data('id');

                if (confirm('هل أنت متأكد من تسجيل الخروج لهذا المستخدم؟')) {
                    $.ajax({
                        url: `{{ route("students.logout", ["id" => ":id"]) }}`
                            .replace(':id', userId),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                        },
                        success: function (response) {
                            if (response.key === 'success') {
                                toastr.success(response.msg, 'نجاح');
                            }
                        },
                        error: function (response) {
                            toastr.error(response.responseJSON.msg, 'خطأ');
                        }
                    });
                }
            });

            $('#userForm').on('submit', function (e) {
                e.preventDefault(); // Prevent form from submitting normally

                // Clear previous validation error messages
                $('.form-control').removeClass('is-invalid'); // Remove error highlighting
                $('.invalid-feedback').remove(); // Remove existing error messages

                // Gather form data
                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("students.store") }}', // Adjust route as needed
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#saveUser').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
                    },
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.message, 'نجاح', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500,
                            });

                            // Close modal
                            $('#modaldemo8').modal('hide');

                            // Clear form
                            $('#userForm')[0].reset();
                            $('#subject').val(null).trigger('change'); // Clear the multi-select

                            // Simulate a click on the reloadTable button
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
                            // Display validation errors
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                let input = $('[name="' + key + '"]'); // Select the input with the error
                                input.addClass('is-invalid'); // Add error highlighting
                                input.after('<div class="invalid-feedback">' + value[0] + '</div>'); // Show error message
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
                        $('#saveUser').html('إضافة').attr('disabled', false);
                    }
                });
            });

            $(document).on('change','#grade',function(){
                const gradeId = $(this).val();
                const subjectDropdown = $('#subject');

                // Clear existing subjects
                subjectDropdown.html('<option value="">اختر المادة</option>');

                if (gradeId) {
                    $.ajax({
                        url: `{{ route('subjects.getSubjects', '') }}/${gradeId}`,
                        type: 'GET',
                        success: function (response) {
                            if (response.subjects && response.subjects.length > 0) {
                                response.subjects.forEach(subject => {
                                    subjectDropdown.append(`<option value="${subject.id}">${subject.name}</option>`);
                                });
                            } else {
                                subjectDropdown.html('<option value="">لا توجد مواد متاحة</option>');
                            }
                        },
                        error: function () {
                            alert('خطأ في استرجاع المواد.');
                        }
                    });
                }
            });

            $(document).on('change','#editGrade',function(){
                const gradeId = $(this).val();
                const subjectDropdown = $('#editSubject');

                // Clear existing subjects
                subjectDropdown.html('<option value="">اختر المادة</option>');

                if (gradeId) {
                    $.ajax({
                        url: `{{ route('subjects.getSubjects', '') }}/${gradeId}`,
                        type: 'GET',
                        success: function (response) {
                            if (response.subjects && response.subjects.length > 0) {
                                response.subjects.forEach(subject => {
                                    subjectDropdown.append(`<option value="${subject.id}">${subject.name}</option>`);
                                });
                            } else {
                                subjectDropdown.html('<option value="">لا توجد مواد متاحة</option>');
                            }
                        },
                        error: function () {
                            alert('خطأ في استرجاع المواد.');
                        }
                    });
                }
            });

        });
    </script>
@endsection
