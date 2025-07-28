<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $services = Service::all();
        $tours = Tour::all();
        return view('admin.products.create', compact('services', 'tours'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|array',
            'slug' => 'nullable|string|max:255',
            'short_description' => 'nullable|array',
            'description'       => 'nullable|array',
            'price'             => 'required|numeric',
            //'category'       => 'required|string|max:100', // УБРАТЬ
            //'subcategory'    => 'nullable|string|max:100', // УБРАТЬ
            'type'              => 'required|string|max:30', // jewelry, wear, service, tour
            'media'             => 'nullable', // Сюда либо массив, либо json-строка
            'attributes'        => 'nullable|array',
            'service_id'        => 'nullable|exists:services,id',
            'tour_id'           => 'nullable|exists:tours,id',
            'stock'             => 'nullable|integer|min:0',
            'status'            => 'nullable|string|max:50',
        ]);
    
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']['en'] ?? reset($data['title']));
        
    
        // --- Media сохранять как массив ---
        if (!empty($data['media'])) {
            if (is_string($data['media'])) {
                $data['media'] = json_decode($data['media'], true) ?? [];
            }
        } else {
            $data['media'] = [];
        }
    
        // --- Очистка связей по типу товара ---
        if ($data['type'] === 'service') {
            $data['tour_id'] = null;
        } elseif ($data['type'] === 'tour') {
            $data['service_id'] = null;
        } else {
            $data['service_id'] = null;
            $data['tour_id'] = null;
        }

        \Log::info('MEDIA INPUT', [
            'raw' => $request->input('media'),
            'json_decoded' => json_decode($request->input('media'), true),
        ]);

        \Log::info('ATTRIBUTES INPUT', [
            'input' => $request->input('attributes'),
        ]);
        
        foreach (['title', 'short_description', 'description'] as $field) {
            $data[$field] = [
                'ru' => $request->input("{$field}.ru"),
                'en' => $request->input("{$field}.en"),
            ];
        }        

    
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Товар добавлен');
    }
    


    public function edit(Product $product)
    {
        $services = Service::all();
        $tours = Tour::all();
        return view('admin.products.edit', compact('product', 'services', 'tours'));
    }

    public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'title'             => 'required|array',
        'slug' => 'nullable|string|max:255' . $product->id,
        'short_description' => 'nullable|array',
        'description'       => 'nullable|array',
        'price'             => 'required|numeric',
       // 'category'       => 'required|string|max:100', // УБРАТЬ
       // 'subcategory'    => 'nullable|string|max:100', // УБРАТЬ
        'type'              => 'required|string|max:30',
        'media'             => 'nullable',
        'attributes'        => 'nullable|array',
        'service_id'        => 'nullable|exists:services,id',
        'tour_id'           => 'nullable|exists:tours,id',
        'stock'             => 'nullable|integer|min:0',
        'status'            => 'nullable|string|max:50',
    ]);

    $data['slug'] = $data['slug'] ?? Str::slug($data['title']['en'] ?? reset($data['title']));
    

    if (!empty($data['media'])) {
        if (is_string($data['media'])) {
            $data['media'] = json_decode($data['media'], true) ?? [];
        }
    } else {
        $data['media'] = [];
    }

    if ($data['type'] === 'service') {
        $data['tour_id'] = null;
    } elseif ($data['type'] === 'tour') {
        $data['service_id'] = null;
    } else {
        $data['service_id'] = null;
        $data['tour_id'] = null;
    }

    \Log::info('ATTRIBUTES INPUT', [
        'input' => $request->input('attributes'),
    ]);
    
    foreach (['title', 'short_description', 'description'] as $field) {
        $data[$field] = [
            'ru' => $request->input("{$field}.ru"),
            'en' => $request->input("{$field}.en"),
        ];
    }
    


    $product->update($data);
    return redirect()->route('products.index')->with('success', 'Товар обновлён');
}



    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Товар удалён');
    }
}
