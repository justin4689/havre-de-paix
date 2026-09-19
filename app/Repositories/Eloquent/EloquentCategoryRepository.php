<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function allOrdered(): Collection
    {
        return Category::query()->withCount('rooms')->ordered()->get();
    }

    public function create(array $attributes): Category
    {
        $category = Category::create($attributes);
        Category::flushLabelMap();

        return $category;
    }

    public function update(Category $category, array $attributes): Category
    {
        $category->update($attributes);
        Category::flushLabelMap();

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
        Category::flushLabelMap();
    }

    public function slugExists(string $slug): bool
    {
        return Category::where('slug', $slug)->exists();
    }
}
