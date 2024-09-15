@extends('layouts.master')

@section('title', 'Dashboard')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Thống kê</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title"> Kết quả học tập theo chuyên ngành</h5>

                            <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="facultySelect" class="form-label">Chọn Khoa</label>
                                        <select id="facultySelect" name="faculty_id" class="form-select">
                                            <option value="">Chọn Khoa</option>
                                            @foreach ($faculties as $faculty)
                                                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="majorSelect" class="form-label">Chọn Chuyên Ngành</label>
                                        <select id="majorSelect" name="major_id" class="form-select">
                                            <option value="">Chọn Chuyên Ngành</option>
                                            <!-- Options sẽ được cập nhật qua AJAX -->
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Xem Biểu Đồ</button>
                                </div>
                            </form>

                            <div class="mt-4">
                                <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@push('style')
@endpush

@push('script')
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);

            const echart = echarts.init(document.querySelector("#trafficChart"));
            echart.setOption({
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    top: '5%',
                    left: 'center'
                },
                series: [{
                    name: 'Tỉ Lệ',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: '18',
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: Object.entries(chartData).map(([key, value]) => ({
                        name: key,
                        value: value,
                        itemStyle: {
                            color: getColorByClassification(key)
                        }
                    }))
                }]
            });

            function getColorByClassification(classification) {
                switch (classification) {
                    case 'Loại Yếu':
                        return '#FF4C4C';
                    case 'Loại Trung bình':
                        return '#FFCE5C';
                    case 'Loại Khá':
                        return '#5CFF5C';
                    case 'Loại Giỏi':
                        return '#5CC2FF';
                    default:
                        return '#0D6EFD';
                }
            }

            // Xử lý sự kiện khi chọn khoa
            $('#facultySelect').change(function() {
                let faculty_id = $(this).val();
                if (faculty_id) {
                    $.ajax({
                        url: '{{ route('majors.by.faculty') }}',
                        type: 'GET',
                        data: {
                            faculty_id: faculty_id
                        },
                        success: function(data) {
                            let majorSelect = $('#majorSelect');
                            majorSelect.empty();
                            majorSelect.append('<option value="">Chọn Chuyên Ngành</option>');
                            $.each(data, function(index, major) {
                                majorSelect.append('<option value="' + major.id + '">' +
                                    major.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#majorSelect').empty().append('<option value="">Chọn Chuyên Ngành</option>');
                }
            });
        });
    </script>
@endpush
