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
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ بنك الأسئلة</span>
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
                        <h4 class="card-title mg-b-0">الأسئلة</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-fall"
                           data-toggle="modal" href="#modaldemo8">إضافة سؤال</a>
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

    <div class="modal" id="editQuestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editQuestionForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل سؤال</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <input type="hidden" name="subject_id" value="{{$id}}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="question" class="form-label">السؤال</label>
                            <input type="text" name="question" class="form-control" id="question" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="answer" class="form-label">الإجابة</label>
                            <input type="text" name="answer" class="form-control" id="answer" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="question_id" class="form-label">الفصل</label>
                            <select class="form-control" name="question_id" id="question_id">
                                @foreach($chapters as $chapter)
                                    <option value="{{$chapter->id}}">{{$chapter->name}}</option>
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
                    <form class="form-horizontal" id="questionForm">
                        @csrf
                        <input type="hidden" name="subject_id" value="{{$id}}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="question" class="form-label">السؤال</label>
                                <input type="text" name="question" class="form-control" id="question" required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="answer" class="form-label">الإجابة</label>
                                <input type="text" name="answer" class="form-control" id="answer" required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="question_id" class="form-label">الفصل</label>
                                <select class="form-control" name="question_id" id="question_id">
                                    @foreach($chapters as $chapter)
                                        <option value="{{$chapter->id}}">{{$chapter->name}}</option>
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
    @include('platform.layouts.get_data' , ['index_route' => url('platform/questions/'.$id)])

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                let bankId = $(this).data('id');

                $.ajax({
                    url: `{{ route("questions.get-question-data", '') }}/${bankId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.key === 'success') {
                            let question = response.data;
                            $('#editQuestionModal').modal('show');
                            $('#editQuestionForm [name="id"]').val(question.id);
                            $('#editQuestionForm [name="question"]').val(question.question);
                            $('#editQuestionForm [name="answer"]').val(question.answer);
                            $('#editQuestionForm [name="chapter_id"]').val(question.chapter_id);
                            $('#editQuestionForm [name="subject_id"]').val(question.subject_id);
                        }
                    }
                });
            });

            $('#editQuestionForm').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let questionId = $('#editQuestionForm [name="id"]').val();

                $.ajax({
                    url: `{{ route("questions.update", '') }}/${questionId}`,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.msg, 'نجاح');
                            $('#editQuestionModal').modal('hide');
                            $('.reloadTable').trigger('click');
                        }
                    }
                });
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let questionId = $(this).data('id');

                if (confirm('هل أنت متأكد من حذف هذا السؤال؟')) {
                    $.ajax({
                        url: `{{ route("questions.delete", ":id") }}`.replace(':id', questionId),
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

            $('#questionForm').on('submit', function (e) {
                e.preventDefault();

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("questions.store") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#saveQuestion').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
                    },
                    success: function (response) {
                        if (response.key === 'success') {
                            toastr.success(response.message, 'نجاح', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500,
                            });

                            $('#modaldemo8').modal('hide');
                            $('#questionForm')[0].reset();
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
                        $('#saveQuestion').html('إضافة').attr('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
