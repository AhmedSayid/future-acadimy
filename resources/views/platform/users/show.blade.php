@extends('dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المعلمين</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/عرض المعلم</span>
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
                        <h4 class="card-title mg-b-0">عرض المعلم</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">الإسم</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control" id="editName"
                                   disabled>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">الهاتف</label>
                            <input type="text" name="phone" value="{{$user->phone}}" class="form-control" id="editPhone"
                                   disabled>
                        </div>
                        <div class="form-group">
                            <label for="image">الصورة</label>
                            @isset($user->image)
                                <img src="{{ Storage::url($row->image) }}" alt="Image" class="img-thumbnail mt-2" style="max-width: 150px; height: auto;">
                            @endisset
                        </div>
                    </form>
                    <hr>
                    <h5>الطلاب المسجلين معه</h5>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">عدد المواد المسجلة</th>
                                    <th class="border-bottom-0">عدد الطلاب المسجلين</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $subjects_count }}</td>
                                    <td>{{ $students_count }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
@endsection
