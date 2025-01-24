<div class="row row-sm">
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">عدد الطلاب</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$data['students']->count()}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">عدد الطلاب المسجلين</p>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">عدد الصفوف الدراسية</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$data['grades']}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">عدد الصفوف الدراسية المضافة</p>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">عدد الفيديوهات</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$data['courses']}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">عدد الفيديوهات المسجلة</p>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">عدد المواد المسجلة</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$data['subjects']->count()}}</h4>
                            <p class="mb-0 tx-12 text-white op-7">عدد المواد المسجلة</p>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-md-12">
        <div class="card card-table-two">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mb-1">اخر الطلاب المسجلين</h4>
                <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
            <span class="tx-12 tx-muted mb-3 ">اخر 10 طلاب مسجلين</span>
            <div class="table-responsive country-table">
                <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                    <thead>
                    <tr>
                        <th class="wd-lg-25p">اسم الطالب</th>
                        <th class="wd-lg-25p tx-right">رقم الهاتف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['students']->take(10) as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-3 mt-3">
                    <a href="{{route('students.index')}}" class="btn btn-outline-primary btn-block">عرض جميع الطلاب</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-table-two">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mb-1">اخر المواد المسجلة</h4>
                <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
            <span class="tx-12 tx-muted mb-3 ">اخر 10 مواد مسجلة</span>
            <div class="table-responsive country-table">
                <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                    <thead>
                    <tr>
                        <th class="wd-lg-25p">اسم المادة</th>
                        <th class="wd-lg-25p tx-right">اسم الفرقة</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['subjects']->take(10) as $subject)
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->grade->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-3 mt-3">
                    <a href="{{route('subjects.index')}}" class="btn btn-outline-primary btn-block">عرض جميع المواد</a>
                </div>
            </div>
        </div>
    </div>
</div>
