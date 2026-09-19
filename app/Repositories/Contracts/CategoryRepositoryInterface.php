<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /** Toutes les catégories triées, avec le nombre de chambres rattachées. */
    public function allOrdered(): Collection;

    public function create(array $attributes): Category;

    public function update(Category $category, array $attributes): Category;

    public function delete(Category $category): void;

    public function slugExists(string $slug): bool;
}
