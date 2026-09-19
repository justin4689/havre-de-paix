<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryAdminService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryAdminService $categoryService,
    ) {}

    public function index(Request $request)
    {
        return view('admin.categories.index', [
            'categories' => $this->categoryService->all(),
            'editing' => $request->filled('edit') ? Category::find($request->integer('edit')) : null,
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée.');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryService->update($category, $request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }
}
