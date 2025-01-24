@extends('dashboard.layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفصول</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">عرض الفصول</span>
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
                        <h4 class="card-title mg-b-0">الفصول</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-fall"
                           data-toggle="modal" href="#modaldemo8">إضافة فصل</a>
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

    <div class="modal" id="editChapterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editChapterForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل فصل</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">الإسم</label>
                            <input type="text" name="name" class="form-control" id="editName" required>
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
                    <h6 class="modal-title">إضافة فصل</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="chapterForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">الإسم</label>
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="الإسم">
                            <input type="hidden" name="subject_id" value="{{$id}}">
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
    @include('platform.layouts.get_data' , ['index_route' => url('platform/chapters/'.$id)])

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                let chapterId = $(this).data('id');

                $.ajax({
                    url: `{{ route("chapters.get-chapter-data", '') }}/${chapterId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.key === 'success') {
                            let chapter = response.data;
                            $('#editChapterModal').modal('show');
                            $('#editChapterForm [name="name"]').val(chapter.name);
                            $('#editChapterForm [name="id"]').val(chapter.id);
                        }
                    }
                });
            });

            $('#editChapterForm').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let chapterId = $('#editChapterForm [name="id"]').val();

                $.ajax({
                    url: `{{ route("chapters.update", '') }}/${chapterId}`,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.msg, 'نجاح');
                            $('#editChapterModal').modal('hide');
                            $('.reloadTable').trigger('click');
                        }
                    }
                });
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let chapterId = $(this).data('id');

                if (confirm('هل أنت متأكد من حذف هذا الفصل؟')) {
                    $.ajax({
                        url: `{{ route("chapters.delete", ":id") }}`.replace(':id', chapterId),
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

            $('#chapterForm').on('submit', function (e) {
                e.preventDefault(); // Prevent form from submitting normally

                // Clear previous validation error messages
                $('.form-control').removeClass('is-invalid'); // Remove error highlighting
                $('.invalid-feedback').remove(); // Remove existing error messages

                // Gather form data
                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("chapters.store") }}', // Adjust route as needed
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#saveChapter').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
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
                            $('#chapterForm')[0].reset();

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
                        $('#saveChapter').html('إضافة').attr('disabled', false);
                    }
                });
            });
        });


    </script>
@endsection
