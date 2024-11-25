@extends('layouts.master')

@section('title', 'Lịch sử môn học của sinh viên')

@section('main')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Lịch sử môn học của {{ $student->full_name }}</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Môn học</th>
                                    <th>Trạng thái</th>
                                    <th>Loại</th>
                                    <th>Ngày học</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjectHistory as $history)
                                    <tr>
                                        <td>{{ $history->studentSubjectClasses->subject->name }}</td>
                                        <td>{{ $history->studentSubjectClasses->status }}</td>
                                        <td>{{ $history->type }}</td>
                                        <td>{{ $history->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
