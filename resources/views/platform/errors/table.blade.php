@php use Illuminate\Pagination\AbstractPaginator; @endphp
<table id="example" class="table key-buttons text-md-nowrap">
    <thead>
    <tr>
        <th class="border-bottom-0">#</th>
        <th class="border-bottom-0">التاريخ</th>
        <th class="border-bottom-0">التحكم</th>
    </tr>
    </thead>
    <tbody>
    @php($i = 1)
    @foreach($rows as $row)
        <tr>
            <td>
                {{$i++}}
            </td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('Y-m-d h:i:s A') }}</td>
            <td>
                <a href="#" class="btn btn-outline-primary btn-edit" data-id="{{ $row->id }}">
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
