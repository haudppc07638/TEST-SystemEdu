@if($students->isEmpty())
    <div class="alert alert-info">
        Không tìm thấy sinh viên phù hợp với từ khóa tìm kiếm
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Lớp</th>
                    <th>Ngành</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->code }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->stuClass->name }}</td>
                    <td>{{ $student->major->name }}</td>
                    <td>
                        <a href="{{ route('student.show', $student->id) }}" 
                           class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif