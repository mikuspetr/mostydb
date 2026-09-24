<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(): View
    {
        $ebooks = Ebook::query()
            ->active()
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'author',
                'description',
                'price',
                'cover_image',
                'download_url',
            ]);

        return view('storefront', [
            'ebooks' => $ebooks,
        ]);
    }
}
