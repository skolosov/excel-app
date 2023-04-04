<?php

namespace App\Imports;

use App\Models\LoadPipeline;
use App\Models\TestData;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImport implements ToModel, WithBatchInserts, WithChunkReading,
                             WithHeadingRow, SkipsEmptyRows, WithEvents, ShouldQueue
{
    use Importable;
    use RegistersEventListeners;

    public function __construct(private string $path)
    {
        Cache::put('pathImport', $this->path);
    }

    public function model(array $row): TestData
    {
        return new TestData(
            [
                'name' => $row['name'],
                'date' => Carbon::instance(Date::excelToDateTimeObject($row['date'])),
            ]
        );
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
        $path = Cache::pull('pathImport');
        Log::info('path: ' . $path);
        /** @var LoadPipeline $pipeline */
        LoadPipeline::query()
            ->orderBy('created_at')
            ->first()
            ->delete();
        Storage::disk('local')->delete($path);
    }
}
