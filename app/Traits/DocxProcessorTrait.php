<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Exception;

trait DocxProcessorTrait
{
    public function generatePurePhpDocx(
        string $templateDiskPath,
        array $textReplacements,
        array $imageReplacements = [],
        array $tableData = [],
        string $disk = 'public',
        array $imageDimensions = [
            "width" => null,
            "height" => null,
        ]
    ): string {
        // dd($templateDiskPath);
        // $templateDiskPath = storage_path('app/public/' . $templateDiskPath);
        // dd(Storage::disk($disk)->allDirectories());
        // dd(Storage::disk($disk)->path($templateDiskPath));
        // dd(Storage::disk($disk)->exists($templateDiskPath));
        if (!Storage::disk($disk)->exists($templateDiskPath)) {
            throw new Exception("Template file context missing at: " . $templateDiskPath);
        }

        $templateAbsolutePath = Storage::disk($disk)->path($templateDiskPath);
        $templateProcessor = new TemplateProcessor($templateAbsolutePath);

        foreach ($tableData as $rowPlaceholder => $rows) {
            $count = count($rows);
            $templateProcessor->cloneRow($rowPlaceholder, $count);

            foreach ($rows as $index => $rowData) {
                $rowNumber = $index + 1;
                foreach ($rowData as $key => $value) {
                    $templateProcessor->setValue($key . '#' . $rowNumber, $value);
                }
            }
        }
        foreach ($textReplacements as $key => $value) {
            $templateProcessor->setValue($key, (string) ($value ?? ''));
        }

        foreach ($imageReplacements as $key => $relativeStoragePath) {
            $normalizedKey = str_replace(['$', '{', '}', ' '], '', $key);

            if ($relativeStoragePath && Storage::disk($disk)->exists($relativeStoragePath)) {
                $imagePath = Storage::disk($disk)->path($relativeStoragePath);

                $imageOptions = [
                    'path' => $imagePath,
                    'width' => $imageDimensions['width'] ?? 140,
                    'height' => $imageDimensions['height'] ?? 70,
                    'ratio' => true
                ];

                try {
                    $templateProcessor->setImageValue('${' . $normalizedKey . '}', $imageOptions);
                    $templateProcessor->setImageValue($key, $imageOptions);
                } catch (\Exception $e) {
                    $templateProcessor->setValue($key, '');
                    $templateProcessor->setValue('${' . $normalizedKey . '}', '');
                }
            } else {
                $templateProcessor->setValue($key, '');
                $templateProcessor->setValue('${' . $normalizedKey . '}', '');
            }
        }

        $tempDocxPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'processed_' . uniqid() . '.docx';
        $templateProcessor->saveAs($tempDocxPath);

        return $tempDocxPath;
    }

    public function generatePurePhpPdf(
        string $templateDiskPath,
        array $textReplacements,
        array $imageReplacements = [],
        array $tableData = [],
        string $disk = 'public',
        array $imageDimensions = [
            "width" => null,
            "height" => null,
        ]
    ): string {
        $tempDocxPath = $this->generatePurePhpDocx(
            $templateDiskPath,
            $textReplacements,
            $imageReplacements,
            $tableData,
            $disk,
            $imageDimensions
        );

        $tempDir = sys_get_temp_dir();
        $pathInfo = pathinfo($tempDocxPath);
        $expectedPdfPath = $tempDir . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.pdf';

        try {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $libreOfficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';
                $command = "{$libreOfficePath} --headless --convert-to pdf --outdir \"" . $tempDir . "\" \"" . $tempDocxPath . "\"";
            } else {
                $command = "libreoffice --headless --convert-to pdf --outdir " . escapeshellarg($tempDir) . " " . escapeshellarg($tempDocxPath);
            }
            shell_exec($command);

        } catch (\Exception $e) {
            if (file_exists($tempDocxPath)) {
                @unlink($tempDocxPath);
            }
            throw new Exception("Direct system layout conversion failed: " . $e->getMessage());
        }

        if (file_exists($tempDocxPath)) {
            @unlink($tempDocxPath);
        }

        if (!file_exists($expectedPdfPath)) {
            throw new Exception("Output PDF could not be found. Please verify LibreOffice installation on the target system host.");
        }

        return $expectedPdfPath;
    }
}