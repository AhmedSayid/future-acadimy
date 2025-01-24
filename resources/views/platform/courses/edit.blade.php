@extends('dashboard.layouts.master')
@section('css')
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet"/>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الكورسات</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل فيديو</span>
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
                        <h4 class="card-title mg-b-0">تعديل فيديو</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('courses.update',$course->id)}}" method="post">
                        @csrf

                        <input type="hidden" name="subject_id" value="{{$course->subject_id}}">
                        <div class="form-group">
                            <label for="name">عنوان الفيديو</label>
                            <input type="text" name="name" value="{{$course->name}}" class="form-control" id="inputName"
                                   placeholder="عنوان الفيديو">
                        </div>

                        <div class="form-group">
                            <label for="chapter">الفصل</label>
                            <select class="form-control" name="chapter_id" id="chapter">
                                <option value="">فيديو عام</option>
                                @foreach($chapters as $chapter)
                                    <option value="{{$chapter->id}}" {{$course->chapter_id == $chapter->id? 'selected':''}}>{{$chapter->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="filePath" id="filePath">
                        <div class="form-group">
                            <label for="video">الفيديو</label>
                            <input type="file" name="video" id="video" class="dropify" data-height="200"/>
                            <div class="progress mt-3" style="display: none;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                     aria-valuemax="100">0%
                                </div>
                            </div>
                            <small class="text-danger" id="uploadError" style="display: none;"></small>
                        </div>

                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>

    <script>
        $(document).ready(function (){
            $('#video').on('change', function (e) {
                const file = this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('video', file);
                formData.append('_token', '{{ csrf_token() }}');

                $('.progress').show();
                $('#uploadError').hide();

                $.ajax({
                    url: "{{ route('courses.upload-video') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (e) {
                            if (e.lengthComputable) {
                                let percentComplete = Math.round((e.loaded / e.total) * 100);
                                $('.progress-bar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete).text(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#filePath').val(response.filePath)
                            toastr.success(response.msg, 'تم رفع الفيديو بنجاح');
                        } else {
                            const errors = response.errors
                            $.each(errors, function (message) {
                                toastr.error(errors[message], 'خطأ');
                            });
                            $('#uploadError').text(response.error).show();
                        }
                    },
                    error: function () {
                        $('#uploadError').text('An error occurred while uploading the video.').show();
                    },
                    complete: function () {
                        $('.progress').hide();
                        $('.progress-bar').css('width', '0%').attr('aria-valuenow', '0').text('0%');
                    }
                });
            });
        })
    </script>
@endsection
