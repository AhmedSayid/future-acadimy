@php use Illuminate\Pagination\AbstractPaginator; @endphp
<table id="example" class="table key-buttons text-md-nowrap">
    <thead>
    <tr>
        <th class="border-bottom-0">الإسم</th>
        <th class="border-bottom-0">الفصول</th>
        <th class="border-bottom-0">الفيديوهات</th>
{{--        <th class="border-bottom-0">بنك الأسئلة</th>--}}
        <th class="border-bottom-0">التحكم</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            <td>
                {{$row->name}}
            </td>
            <td>
                <a href="{{route('chapters.index',$row->id)}}" class="btn btn-outline-info">
                    <i class="bi bi-book-fill"></i>
                </a>
            </td>
            <td>
                <a href="{{route('courses.index',$row->id)}}" class="btn btn-outline-dark">
                    <i class="bi bi-camera-video-fill"></i>
                </a>
            </td>
{{--            <td>--}}
{{--                <a href="{{route('questions.index',$row->id)}}" class="btn btn-outline-dark">--}}
{{--                    <i class="bi bi-patch-question-fill"></i>--}}
{{--                </a>--}}
{{--            </td>--}}
            <td>
                <a href="#" class="btn btn-outline-primary btn-edit" data-id="{{ $row->id }}">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-delete" data-id="{{ $row->id }}">
                    <i class="bi bi-trash3-fill"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@if ($rows->count() == 0)
    <div class="form-group" style="text-align: center">
            <span class="btn btn-sm round btn-outline-warning">
                لا يوجد بيانات حاليا <i class="feather icon-rotate-cw"></i>
            </span>
    </div>
@endif
{{-- no data found div --}}
@if ($rows->count() > 0 && $rows instanceof AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$rows->links('pagination::bootstrap-4')}}
    </div>
@endif
