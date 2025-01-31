@extends('dashboard.layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الكورسات</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">عرض الكورسات</span>
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
                        <h4 class="card-title mg-b-0">الكورسات</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="btn btn-outline-primary btn-block"
                           href="{{route('courses.create',$id)}}">إضافة فيديو</a>
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
    <div class="modal" id="modaldemo8" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">عرض الفيديو</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="videoPlayer" style="width: 100%; height: auto;" controls controlsList="nodownload noremoteplayback" disablePictureInPicture>
                        <source src="" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('platform.layouts.get_data' , ['index_route' => url('platform/courses/'.$id)])

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let courseId = $(this).data('id');
                if (confirm('هل أنت متأكد من حذف هذا الكورس؟')) {
                    $.ajax({
                        url: `{{ route("courses.delete", ":id") }}`.replace(':id', courseId),
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
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-show-video', function (e) {
                e.preventDefault();

                let courseId = $(this).data('id');

                $.ajax({
                    url: `{{ route("courses.show", ":id") }}`.replace(':id', courseId),
                    method: 'GET',
                    success: function (response) {
                        let videoPlayer = $('#videoPlayer');
                        videoPlayer.attr('src', response.video_url);
                        videoPlayer[0].load();
                    },
                    error: function (xhr) {
                        alert('حدث خطأ أثناء تحميل الفيديو');
                    }
                });
            });
        });
    </script>

@endsection
