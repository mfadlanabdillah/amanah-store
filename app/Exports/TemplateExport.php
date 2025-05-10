<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ProductsExport(),
            new CategoriesExport(),
            new BrandsExport(),
            new ProductModelsExport(),
        ];
    }
}

class ProductsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'name',
            'stock',
            'price',
            'is_active',
            'image',
            'barcode',
            'brand_id',
            'product_model_id',
            'category_id',
            'imei1',
            'imei2',
            'color',
            'condition',
            'storage_capacity',
            'ram',
            'description'
        ];
    }

    public function title(): string
    {
        return 'Product';
    }
}

class CategoriesExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Category::select('id', 'name', 'is_active')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'is_active',
            'name'
        ];
    }

    public function title(): string
    {
        return 'Category';
    }
}

class BrandsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Brand::select('id', 'name', 'is_active')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'is_active',
            'name'
        ];
    }

    public function title(): string
    {
        return 'Brand';
    }
}

class ProductModelsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return ProductModel::select('id', 'name', 'brand_id', 'is_active')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'is_active',
            'brand_id',
            'name'
        ];
    }

    public function title(): string
    {
        return 'Product Model';
    }
}
