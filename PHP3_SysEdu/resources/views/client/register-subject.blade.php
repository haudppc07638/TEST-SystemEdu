@extends('layouts.app')

@section('title', 'Đăng ký môn học | SysEdu')

@section('main')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700">
                Các lớp môn
            </h2>

            <div class="grid gap-6 mb-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach($subjects as $subject)
                <div class="min-w-0 p-4 bg-gray-400 text-black rounded-lg shadow-xs border border-gray-700">
                    <h4 class="mb-4 font-semibold">
                        {{ $subject->name }}
                    </h4>
                    <p class="mb-4">
                        {{ $subject->description }}
                    </p>
                        <a href="{{ route('client.subject.classes.show', $subject->id) }}">
                            <button
                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Xem các lớp
                            </button>
                        </a>
                </div>
            @endforeach
            </div>
        </div>
    </main>
@endsection
