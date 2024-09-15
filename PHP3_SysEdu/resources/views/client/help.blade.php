@extends('layouts.app')

@section('title', 'Hỗ trợ | SysEdu')

@section('main')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Hỗ Trợ</h1>
    <p class="mb-4">
        Chào mừng đến với trang Trợ Giúp của SysEdu! Tại đây bạn có thể tìm thấy các hướng dẫn và câu trả lời cho các câu hỏi thường gặp.
    </p>

    <div class="max-w-screen-md mx-auto p-10">
      <div id="accordion-flush" data-accordion="collapse"
         data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
         data-inactive-classes="text-gray-500 dark:text-gray-400">
         <h3 id="accordion-flush-heading-1">
            <button type="button"
               class="flex items-center justify-between w-full py-5 px-4 font-medium text-left border-b border-gray-200 dark:border-gray-700 bg-white  text-gray-900"
               data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
               aria-controls="accordion-flush-body-1">
               <span>Một năm trường có mấy đợt xét tốt nghiệp?</span>
               <svg data-accordion-icon="" class="w-6 h-6 shrink-0 rotate-180" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h3>
         <div id="accordion-flush-body-1" class="" aria-labelledby="accordion-flush-heading-1">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">
               <p class="dark:text-purple-500">
                  Một năm có 2 đợt xét tuyển tốt nghiệp
               </p>
            </div>
         </div>
         <h3 id="accordion-flush-heading-2">
            <button type="button"
               class="flex items-center justify-between w-full py-5 px-4 font-medium text-left border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400"
               data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
               aria-controls="accordion-flush-body-2">
               <span>Sinh viên đầu kỳ muốn xin chuyển lớp?</span>
               <svg data-accordion-icon="" class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h3>
         <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">
               <p class="dark:text-purple-500">
                  - Sau khi SV có lịch học, trước khi học kỳ/block bắt đầu sinh viên có thể đổi ca học trên tool tại SysEdu. 
                  <br>
                  - Trường hợp SV không đổi được lịch/đổi nhầm cần sắp xếp thời gian để đảm bảo học theo đúng lộ trình trên SysEdu.
               </p>
            </div>
         </div>
         <h3 id="accordion-flush-heading-3">
            <button type="button"
               class="flex items-center justify-between w-full py-5 px-4 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
               data-accordion-target="#accordion-flush-body-3" aria-expanded="false"
               aria-controls="accordion-flush-body-3">
               <span>Điều kiện để sinh viên tốt nghiệp ?</span>
               <svg data-accordion-icon="" class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h3>
         <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">
               
               <p class="dark:text-purple-500">SV cần hoàn thành tất cả các môn học và không nợ học phí, đã có bản sao bẳng TN, không nợ Học phí sẽ đủ điều kiện để xét TN</p>
            
            </div>
         </div>
         <h3 id="accordion-flush-heading-4">
            <button type="button"
               class="flex items-center justify-between w-full py-5 px-4 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
               data-accordion-target="#accordion-flush-body-4" aria-expanded="false"
               aria-controls="accordion-flush-body-4">
               <span>Hình thức khen thưởng đối với sinh viên có thành tích học tập tốt ?</span>
               <svg data-accordion-icon="" class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h3>
         <div id="accordion-flush-body-4" class="hidden" aria-labelledby="accordion-flush-heading-4">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">
               <p class="dark:text-purple-500">
                  - Hàng kỳ Nhà trường sẽ tổ chức Lễ tôn vinh Sinh viên tiêu biểu nằm trong TOP toàn trường.
                  <br>
                  - Hình thức khen thưởng: Giấy khen + Tiền mặt
                  <br>
                  - Đối với sinh viên đạt điểm 8.0 trở lên nhưng không nằm trong TOP toàn trường sẽ được khen thưởng bằng hình thức giấy khen
               </p>           
            </div>
         </div>
      </div>
   </div>
   
     
</div>

@endsection