<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Список блоков
     */
    public function index()
    {
        $blocks = Block::orderBy('order')->get();
        return view('admin.blocks.index', compact('blocks'));
    }

    /**
     * Форма редактирования блока
     */
    public function edit(Block $block)
    {
        return view('admin.blocks.edit', compact('block'));
    }

    /**
     * Обновление блока
     */
    public function update(Request $request, Block $block)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'media' => 'nullable|string',  // JSON в textarea
            'type' => 'required|string|in:image,video,slider,custom',
            'order' => 'nullable|integer',
            'status' => 'required|string|in:draft,published',
        ]);

        // Обработка поля media как JSON
        $data['media'] = $data['media'] ? json_decode($data['media'], true) : null;

        $block->update($data);

        return redirect()->route('admin.blocks.index')->with('success', 'Блок обновлён');
    }

    /**
     * Форма создания блока
     */
    public function create()
    {
        return view('admin.blocks.create');
    }

    /**
     * Сохранение нового блока
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:blocks,key',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'media' => 'nullable|string',  // JSON
            'type' => 'required|string|in:image,video,slider,custom',
            'order' => 'nullable|integer',
            'status' => 'required|string|in:draft,published',
        ]);

        $data['media'] = $data['media'] ? json_decode($data['media'], true) : null;

        Block::create($data);

        return redirect()->route('admin.blocks.index')->with('success', 'Блок создан');
    }

    /**
     * Удаление блока
     */
    public function destroy(Block $block)
    {
        $block->delete();
        return redirect()->route('admin.blocks.index')->with('success', 'Блок удалён');
    }
}
