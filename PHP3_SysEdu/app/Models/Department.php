<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'id',
        'name',
        'location',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public static function getNameDepartments()
    {
        return Department::select('id', 'name', 'location')
        ->orderBy('id', 'desc')
        ->get();
    }

    public static function updateDepartment($id, $data){
        $department = self::findOrFail($id);
        $department->update($data);
        return $department;
    }

    public static function deleteDepartment($id)
    {
        return Department::findOrFail($id)
        ->delete();
    }


}
