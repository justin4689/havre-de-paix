<?php

namespace App\Http\Controllers;

use App\Services\RoomCatalogService;

class HomeController extends Controller
{
    public function __construct(
        private readonly RoomCatalogService $catalog,
    ) {}

    public function index()
    {
        return view('home', ['roomsByCategory' => $this->catalog->representativeByCategory()]);
    }
}
