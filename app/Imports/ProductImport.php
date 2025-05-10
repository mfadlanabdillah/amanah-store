<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithMultipleSheets, SkipsEmptyRows, WithValidation
{

    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Product([
            'name' => $row['name'],
            'slug' => Product::generateUniqueSlug($row['name']),
            'stock' => $row['stock'] ?? 0,
            'price' => $row['price'] ?? 0,
            'is_active' => $row['is_active'] ?? true,
            'image' => array_key_exists('image', $row) ? $row['image'] : null,
            'barcode' => array_key_exists('barcode', $row) ? $row['barcode'] : null,
            'brand_id' => $row['brand_id'] ?? null,
            'product_model_id' => $row['product_model_id'] ?? null,
            'category_id' => $row['category_id'] ?? null,
            'imei1' => array_key_exists('imei1', $row) ? $row['imei1'] : null,
            'imei2' => array_key_exists('imei2', $row) ? $row['imei2'] : null,
            'color' => array_key_exists('color', $row) ? $row['color'] : null,
            'condition' => array_key_exists('condition', $row) ? $row['condition'] : null,
            'storage_capacity' => array_key_exists('storage_capacity', $row) ? $row['storage_capacity'] : null,
            'screen_size' => array_key_exists('screen_size', $row) ? $row['screen_size'] : null,
            'processor' => array_key_exists('processor', $row) ? $row['processor'] : null,
            'ram' => array_key_exists('ram', $row) ? $row['ram'] : null,
            'battery_capacity' => array_key_exists('battery_capacity', $row) ? $row['battery_capacity'] : null,
            'additional_specs' => array_key_exists('additional_specs', $row) ? $row['additional_specs'] : null,
            'description' => array_key_exists('description', $row) ? $row['description'] : null
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string',
            '*.stock' => 'nullable|numeric|min:0',
            '*.price' => 'nullable|numeric|min:0',
            '*.is_active' => 'nullable|boolean',
            '*.image' => 'nullable|string',
            '*.barcode' => 'nullable|string|unique:products,barcode',
            '*.brand_id' => 'nullable|exists:brands,id|numeric',
            '*.product_model_id' => 'nullable|exists:product_models,id|numeric',
            '*.category_id' => 'nullable|exists:categories,id|numeric',
            '*.imei1' => 'nullable|string',
            '*.imei2' => 'nullable|string',
            '*.color' => 'nullable|string',
            '*.condition' => 'nullable|string',
            '*.storage_capacity' => 'nullable|string',
            '*.screen_size' => 'nullable|string',
            '*.processor' => 'nullable|string',
            '*.ram' => 'nullable|string',
            '*.battery_capacity' => 'nullable|string',
            '*.additional_specs' => 'nullable|string',
            '*.description' => 'nullable|string'
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.name' => 'Kolom: attribute harus diisi',
            '*.stock' => 'Kolom: attribute harus diisi',
            '*.price' => 'Kolom: attribute harus diisi',
            '*.is_active' => 'Kolom: attribute tidak valid (TRUE/FALSE)',
            '*.brand_id' => 'Kolom: attribute tidak valid (ID)',
            '*.product_model_id' => 'Kolom: attribute tidak valid (ID)',
            '*.category_id' => 'Nilai: attribute sudah ada sebelumnya',
            '*.imei1' => 'Kolom: attribute tidak valid (IMEI)',
            '*.imei2' => 'Kolom: attribute tidak valid (IMEI)',
            '*.color' => 'Kolom: attribute tidak valid (Color)',
            '*.condition' => 'Kolom: attribute tidak valid (Condition)',
            '*.storage_capacity' => 'Kolom: attribute tidak valid (Storage Capacity)',
            '*.screen_size' => 'Kolom: attribute tidak valid (Screen Size)',
            '*.processor' => 'Kolom: attribute tidak valid (Processor)',
            '*.ram' => 'Kolom: attribute tidak valid (RAM)',
            '*.battery_capacity' => 'Kolom: attribute tidak valid (Battery Capacity)',
            '*.additional_specs' => 'Kolom: attribute tidak valid (Additional Specs)',
            '*.description' => 'Kolom: attribute tidak valid (Description)'
        ];
    }
}
