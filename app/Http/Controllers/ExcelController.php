<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelLoadRequest;
use App\Services\ExcelLoadService;

class ExcelController extends Controller
{
    public function __construct(public ExcelLoadService $service)
    {
    }

    public function load(ExcelLoadRequest $request)
    {
        $this->service->load($request->file('file'));
    }

    public function index()
    {
        return response()->json(
            $this->service->index()
        );
    }
}
