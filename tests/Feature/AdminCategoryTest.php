<?php

use App\Models\Category;
use App\Models\Room;
use App\Models\User;
use App\Services\RoomCatalogService;

function actingAsAdmin(): User
{
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin-test@example.com',
        'password' => bcrypt('secret-test'),
        'role' => 'admin',
    ]);

    test()->actingAs($admin);

    return $admin;
}

function makeCategory(array $attributes = []): Category
{
    return Category::create([
        'slug' => 'bungalow',
        'name' => 'Bungalow',
        'sort_order' => 1,
        ...$attributes,
    ]);
}

it('crée une catégorie avec un slug généré automatiquement', function () {
    actingAsAdmin();

    $this->post(route('admin.categories.store'), [
        'name' => 'Bungalow Lagune',
        'name_en' => 'Lagoon Bungalow',
        'tagline' => 'Face à la lagune',
        'sort_order' => 5,
    ])->assertRedirect(route('admin.categories.index'));

    $this->assertDatabaseHas('categories', [
        'slug' => 'bungalow-lagune',
        'name' => 'Bungalow Lagune',
        'name_en' => 'Lagoon Bungalow',
    ]);
});

it('renomme une catégorie sans changer son slug', function () {
    actingAsAdmin();
    $category = makeCategory();

    $this->patch(route('admin.categories.update', $category), [
        'name' => 'Bungalow Premium',
    ])->assertRedirect(route('admin.categories.index'));

    $category->refresh();
    expect($category->name)->toBe('Bungalow Premium')
        ->and($category->slug)->toBe('bungalow');
});

it('refuse de supprimer une catégorie rattachée à des chambres', function () {
    actingAsAdmin();
    $category = makeCategory();

    Room::create([
        'slug' => 'chambre-test', 'name' => 'Chambre Test',
        'description_short' => 'Test', 'capacity_adults' => 2, 'capacity_children' => 0,
        'size_m2' => 20, 'bed_type' => 'double', 'floor' => 1, 'category' => 'bungalow',
        'amenities' => [], 'images' => [], 'price_per_night' => 50000,
        'min_nights' => 1, 'status' => 'active',
    ]);

    $this->from(route('admin.categories.index'))
        ->delete(route('admin.categories.destroy', $category))
        ->assertSessionHasErrors('category');

    $this->assertDatabaseHas('categories', ['slug' => 'bungalow']);
});

it('supprime une catégorie sans chambre', function () {
    actingAsAdmin();
    $category = makeCategory();

    $this->delete(route('admin.categories.destroy', $category))
        ->assertRedirect(route('admin.categories.index'));

    $this->assertDatabaseMissing('categories', ['slug' => 'bungalow']);
});

it('affiche la chambre mise en avant sur l\'accueil, sinon la moins chère', function () {
    actingAsAdmin();
    $category = makeCategory();

    $cheap = Room::create([
        'slug' => 'bungalow-eco', 'name' => 'Bungalow Éco',
        'description_short' => 'Test', 'capacity_adults' => 2, 'capacity_children' => 0,
        'size_m2' => 20, 'bed_type' => 'double', 'floor' => 1, 'category' => 'bungalow',
        'amenities' => [], 'images' => [], 'price_per_night' => 40000,
        'min_nights' => 1, 'status' => 'active',
    ]);
    $premium = Room::create([
        'slug' => 'bungalow-vue', 'name' => 'Bungalow Vue',
        'description_short' => 'Test', 'capacity_adults' => 2, 'capacity_children' => 0,
        'size_m2' => 30, 'bed_type' => 'king', 'floor' => 1, 'category' => 'bungalow',
        'amenities' => [], 'images' => [], 'price_per_night' => 90000,
        'min_nights' => 1, 'status' => 'active',
    ]);

    $service = app(RoomCatalogService::class);

    // Sans choix : la moins chère
    expect($service->representativeByCategory()->get('bungalow')->id)->toBe($cheap->id);

    // Choix enregistré depuis l'admin : la chambre vitrine prime
    $this->patch(route('admin.categories.update', $category), [
        'name' => 'Bungalow',
        'featured_room_id' => $premium->id,
    ])->assertRedirect(route('admin.categories.index'));

    expect($service->representativeByCategory()->get('bungalow')->id)->toBe($premium->id);

    // Chambre vitrine désactivée : repli sur la moins chère active
    $premium->update(['status' => 'inactive']);
    expect($service->representativeByCategory()->get('bungalow')->id)->toBe($cheap->id);
});
