@php use Illuminate\Pagination\AbstractPaginator; @endphp
<table id="example" class="table key-buttons text-md-nowrap">
    <thead>
    <tr>
        <th class="border-bottom-0">الإسم</th>
        <th class="border-bottom-0">الهاتف</th>
        <th class="border-bottom-0">حالة الحظر</th>
        <th class="border-bottom-0">التحكم</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            <td>
                {{$row->student?->user?->name}}
            </td>
            <td>
                {{$row->student?->user?->phone}}
            </td>
            <td>
                @if(!$row->student?->user?->is_blocked)
                    <span class="btn btn-sm rounded-5 round btn-outline-success">
                        مفعل
                        <i class="feather icon-rotate-cw"></i>
                    </span>
                    <span class="btn btn-sm rounded-5 round btn-outline-danger change_status" data-id="{{$row->id}}">
                        حظر
                    </span>
                @else
                    <span class="btn btn-sm rounded-5 btn-outline-danger">
                        محظور
                        <i class="feather icon-rotate-cw"></i>
                    </span>
                    <span class="btn btn-sm rounded-5 round btn-outline-success change_status" data-id="{{$row->id}}">
                        تفعيل
                    </span>
                @endif
            </td>
            <td>
                <a href="#" class="btn btn-outline-primary btn-edit" data-id="{{ $row->student?->user?->id }}">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="{{route('students.show' , $row->id)}}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-eye-fill"></i>
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
