<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class UbigeoController extends Controller
{
    public function getDepartments()
    {
        $departments = Department::where('active', 1)
            ->orderBy('description')
            ->get(['id', 'description']);

        return ApiResponse::success('Departamentos obtenidos correctamente.', $departments);
    }

    public function getProvinces($department_id)
    {
        $provinces = Province::where('active', 1)
            ->where('department_id', $department_id)
            ->orderBy('description')
            ->get(['id', 'description']);

        return ApiResponse::success('Provincias obtenidas correctamente.', $provinces);
    }

    public function getDistricts($department_id, $province_id)
    {
        $districts = District::where('active', 1)
            ->where('department_id', $department_id)
            ->where('province_id', $province_id)
            ->orderBy('description')
            ->get(['id', 'description']);

        return ApiResponse::success('Distritos obtenidos correctamente.', $districts);
    }
}
