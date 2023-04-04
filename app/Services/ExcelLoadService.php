<?php


namespace App\Services;


use App\Imports\ExcelImport;
use App\Models\LoadPipeline;
use App\Models\TestData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelLoadService
{
    public function load(UploadedFile $file): void
    {
        $path = $file->store('local');
        LoadPipeline::query()->create(['path' => $path]);
        $filePath = Storage::path($path);
        Excel::import(new ExcelImport($path), $filePath);
    }

    public function index(): array
    {
        $data = [];
        foreach (TestData::query()->lazy() as $row) {
            /** @var TestData $row */
            $data[Carbon::parse($row->date)->format('d.m.Y')][] = $row->toArray();
        }
        return $data;
    }
}
