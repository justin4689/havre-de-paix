<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryAdminService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categories,
    ) {}

    public function all(): Collection
    {
        return $this->categories->allOrdered();
    }

    /**
     * Le slug est dérivé du nom à la création puis reste immuable :
     * les chambres et les URLs filtrées s'y réfèrent.
     */
    public function create(array $validated): Category
    {
        $validated['slug'] = $this->uniqueSlug($validated['name']);

        return $this->categories->create($validated);
    }

    public function update(Category $category, array $validated): Category
    {
        unset($validated['slug']);

        return $this->categories->update($category, $validated);
    }

    /** Une catégorie encore rattachée à des chambres ne peut pas être supprimée. */
    public function delete(Category $category): void
    {
        if ($category->rooms()->exists()) {
            throw ValidationException::withMessages([
                'category' => __('Impossible de supprimer : des chambres sont rattachées à cette catégorie. Réaffectez-les d\'abord.'),
            ]);
        }

        $this->categories->delete($category);
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'categorie';
        $slug = $base;
        $i = 2;

        while ($this->categories->slugExists($slug)) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
