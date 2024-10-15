    @extends('layouts.app')

    @section('title', 'Đăng ký lớp học | SysEdu')

    @section('main')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700">
                Đăng ký lớp học
            </h2>

            <div class="grid gap-6 mb-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($subjectClasses as $subjectClass)
                    <div class="min-w-0 p-4 bg-gray-400 text-black rounded-lg shadow-xs border border-gray-700">
                        <p class="mb-2">
                        <h4 class="mb-4 font-semibold"><span class="font-semibold">Môn:</span>  {{ $subjectClass->subject->name ?? 'N/A' }}</h4>
                        </p>
                        <p class="mb-2">
                            <span class="font-semibold">Lớp Môn:</span> {{ $subjectClass->name }}
                        </p>
                        <p class="mb-2">
                            <span class="font-semibold">Giảng viên:</span> {{ $subjectClass->employee->fullname ?? 'N/A' }}
                        </p>
                        <p class="mb-2">
                            <span class="font-semibold">Ngày học:</span> {{ $subjectClass->start_date }}
                        </p>
                        <p class="mb-2">
                            <span class="font-semibold">Học kỳ:</span> {{ $subjectClass->semester->block ?? 'N/A' }}
                        </p>
                        <p class="mb-2">
                            <span class="font-semibold">Mã môn:</span> {{ $subjectClass->subject->code ?? 'N/A' }}
                        </p>
                        <p class="mb-2">
                            <span class="font-semibold">Hạn chót đăng ký:</span> {{ $subjectClass->registration_deadline }}
                        </p>
                        <p class="mb-4">
                            <span class="font-semibold">Số lượng đã đăng ký:</span> {{ $subjectClass->studentsCountText() }}
                        </p>
                        @if($registeredClass)
                            @if($registeredClass->subjectClass->id == $subjectClass->id)
                                <form action="{{ route('cancelClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                                        Hủy đăng ký
                                    </button>
                                </form>
                            @else
                                <button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg cursor-not-allowed" disabled>
                                    Đã đăng ký lớp khác
                                </button>
                            @endif
                        @else
                        <form action="{{ route('joinClass',$subjectClass->id) }}" method="POST" class="inline-block">
                            @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Đăng ký
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
