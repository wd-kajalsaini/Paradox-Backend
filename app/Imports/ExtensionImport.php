<?php

namespace App\Imports;

use App\CountryExtension;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ExtensionImport implements ToModel, WithStartRow, WithValidation, WithBatchInserts {

    use Importable;

    public function startRow(): int {
        return 2;
    }

    public function batchSize(): int {
        return 100;
    }

    public function model(array $row) {
        //getting merchant id

        return new CountryExtension([
            'extension' => $row[0],
            'country' => $row[1],
            'country_code' => $row[2]
        ]);
    }

    public function rules(): array {
        return [
            '0' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Extension is required');
                }
                if (strlen($value) > 11) {
                    $onFailure('Length of extension must be <= 11');
                }
            },
            '1' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Country is required');
                }
                if (strlen($value) > 51) {
                    $onFailure('Length of extension must be <= 51');
                }
            },
            '2' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Country code is required');
                }
                if (strlen($value) > 51) {
                    $onFailure('Length of extension must be <= 51');
                }
            },
        ];
    }

}
