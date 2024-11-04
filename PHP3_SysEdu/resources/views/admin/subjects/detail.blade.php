@extends('layouts.master')

@section('title', 'Chi Tiết Môn Học')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1><i class='bx bx-id-card'></i> Chi Tiết Môn Học: {{ $subject->name }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Môn</a></li>
                    <li class="breadcrumb-item active">Chi Tiết</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class='bx bx-book'></i> Thông Tin Môn Học</h5>
                            <dl class="row">
                                <dt class="col-sm-3"><strong>Mã môn học:</strong></dt>
                                <dd class="col-sm-9">{{ $subject->code }}</dd>

                                <dt class="col-sm-3"><strong>Tên môn học:</strong></dt>
                                <dd class="col-sm-9">{{ $subject->name }}</dd>

                                <dt class="col-sm-3"><strong>Tín chỉ:</strong></dt>
                                <dd class="col-sm-9">{{ $subject->credit }}</dd>

                                <dt class="col-sm-3"><strong>Mô tả:</strong></dt>
                                <dd class="col-sm-9">{{ $subject->description }}</dd>

                                <dt class="col-sm-3"><strong>Chuyên ngành:</strong></dt>
                                <dd class="col-sm-9">{{ $subject->major ? $subject->major->name : 'Môn cơ bản' }}</dd>
                            </dl>

                            <h5 class="mt-4"><i class='bx bx-list-ul'></i> Các Loại Điểm</h5>
                            <ul class="list-group">
                                @php
                                    $groupedScoreTypes = [];
                                    foreach ($subject->scoreTypes as $scoreType) {
                                        $scoreTypeId = $scoreType->id;
                                        if (!isset($groupedScoreTypes[$scoreTypeId])) {
                                            $groupedScoreTypes[$scoreTypeId] = [
                                                'name' => $scoreType->name,
                                                'weight' => $scoreType->pivot->weight,
                                                'type' => $scoreType->type,
                                                'details' =>
                                                    $scoreType->type === 'multi' ? [$scoreType->pivot->name] : [],
                                            ];
                                        } else {
                                            if ($scoreType->type === 'multi') {
                                                $groupedScoreTypes[$scoreTypeId]['details'][] = $scoreType->pivot->name;
                                            }
                                            $groupedScoreTypes[$scoreTypeId]['weight'] += $scoreType->pivot->weight;
                                        }
                                    }
                                @endphp

                                @foreach ($groupedScoreTypes as $scoreType)
                                    <li class="list-group-item">
                                        <div>
                                            <strong>{{ $scoreType['name'] }}:</strong> {{ $scoreType['weight'] }}%
                                        </div>
                                        @if ($scoreType['type'] === 'multi')
                                            <div class="ms-3 mt-2">
                                                <small class="text-muted">
                                                    Bao gồm:
                                                    @foreach ($scoreType['details'] as $index => $detail)
                                                        <br>- {{ $scoreType['name'] }}{{ $index + 1 }}
                                                        ({{ $scoreType['weight'] / count($scoreType['details']) }}%)
                                                    @endforeach
                                                </small>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            <h5 class="mt-4"><i class='bx bx-exclamation-circle'></i> Môn Tiên Quyết</h5>
                            <ul class="list-group">
                                @if ($subject->prerequisites->isEmpty())
                                    <li class="list-group-item">Không có môn tiên quyết</li>
                                @else
                                    @foreach ($subject->prerequisites as $prerequisite)
                                        <li class="list-group-item">{{ $prerequisite->name }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
