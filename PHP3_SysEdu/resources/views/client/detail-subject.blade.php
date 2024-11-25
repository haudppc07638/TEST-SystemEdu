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
                    @if(\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($subjectClass->registration_deadline)))
                        <div class="min-w-0 p-4 bg-gray-100 text-gray-900 rounded-lg shadow-md border border-gray-300">
                            <h4 class="mb-4 font-semibold text-lg">
                                <span class="font-bold">Môn:</span> {{ $subjectClass->subject->name ?? 'N/A' }}
                            </h4>
                            <p class="mb-2"><span class="font-bold">Lớp Môn:</span> {{ $subjectClass->name }}</p>
                            <p class="mb-2"><span class="font-bold">Giảng viên:</span> {{ $subjectClass->employee->full_name ?? 'N/A' }}</p>
                            <p class="mb-2"><span class="font-bold">Ngày học:</span> {{ $subjectClass->start_date }}</p>
                            <p class="mb-2"><span class="font-bold">Học kỳ:</span> {{ $subjectClass->semester->block ?? 'N/A' }}</p>
                            <p class="mb-2"><span class="font-bold">Mã môn:</span> {{ $subjectClass->subject->code ?? 'N/A' }}</p>
                            <p class="mb-2"><span class="font-bold">Hạn chót đăng ký:</span> {{ $subjectClass->registration_deadline }}</p>
                            <p class="mb-4"><span class="font-bold">Số lượng đã đăng ký:</span> {{ $subjectClass->studentsCountText() }}</p>
            
                            @if($registeredClass)
                            @if($registeredClass->subjectClass->subject_id == $subjectClass->subject_id && $registeredClass->subjectClass->semester_id == $subjectClass->semester_id)  
                                <form action="{{ route('cancelClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                    @csrf
                                        <button type="submit" 
                                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                            Hủy đăng ký
                                        </button>
                                    </form>
                                @else
                                    <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg cursor-not-allowed" disabled>
                                        Đã đăng ký lớp khác
                                    </button>
                                @endif
                            @else
                                @if(!$subjectClass->semester->isCurrentSemester()) 
                                    <form action="{{ route('joinClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                            Đăng ký (Cải thiện điểm)
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('joinClass', $subjectClass->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                                        Đăng ký
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>                        
        </div>
    </main>
@endsection
