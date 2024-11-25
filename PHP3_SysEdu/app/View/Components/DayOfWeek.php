<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DayOfWeek extends Component
{
    public $dayOfWeek;
    public $dayName;

    public function __construct($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;
        $this->dayName = $this->getDayName($dayOfWeek);
    }

    private function getDayName($dayOfWeek)
    {
        $days = [
            1 => 'Thứ Hai',
            2 => 'Thứ Ba', 
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy',
            0 => 'Chủ Nhật'
        ];

        return $days[$dayOfWeek] ?? 'Không xác định';
    }

    public function render()
    {
        return view('components.day-of-week');
    }
}