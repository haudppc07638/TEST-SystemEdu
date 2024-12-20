@extends('layouts.master')

@section('title', 'Dashboard')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Thống kê</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Cards for statistics -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Khoa</h5>
                            <div class="d-flex align-items-center">
                                <div class="icon rounded-circle bg-primary-light text-primary me-3">
                                    <i class="bi bi-bank"></i>
                                </div>
                                <h6 class="mb-0">{{ $facultyCount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Chuyên ngành</h5>
                            <div class="d-flex align-items-center">
                                <div class="icon rounded-circle bg-success-light text-success me-3">
                                    <i class="bi bi-list-task"></i>
                                </div>
                                <h6 class="mb-0">{{ $majorCount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Sinh viên</h5>
                            <div class="d-flex align-items-center">
                                <div class="icon rounded-circle bg-warning-light text-warning me-3">
                                    <i class="bi bi-person"></i>
                                </div>
                                <h6 class="mb-0">{{ $studentCount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card info-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Nhân sự</h5>
                            <div class="d-flex align-items-center">
                                <div class="icon rounded-circle bg-danger-light text-danger me-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6 class="mb-0">{{ $employeeCount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of statistics cards -->

                <!-- Form and chart section -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thống kê số lượng sinh viên nhập học / tháng</h5>

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
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                xAxis: {
                    type: 'category',
                    data: Object.keys(chartData),
                    axisTick: {
                        alignWithLabel: true
                    }
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    name: 'Số lượng',
                    type: 'bar',
                    barWidth: '50%',
                    data: Object.values(chartData),
                    itemStyle: {
                        color: '#3498db'
                    }
                }]
            });
        });
    </script>
@endpush
