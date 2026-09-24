<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    public function run(): void
    {
        $ebooks = [
            [
                'title' => 'Laravel pro moderní web',
                'author' => 'Jan Novák',
                'description' => 'Praktický průvodce stavbou moderních aplikací v Laravelu od architektury po nasazení.',
                'price' => 299.00,
                'cover_image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=900&q=80',
                'download_url' => 'https://example.com/downloads/laravel-pro-moderni-web.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Vue.js v praxi',
                'author' => 'Petra Svobodová',
                'description' => 'Srozumitelný ebook pro tvorbu interaktivních komponent, formulářů a administrací ve Vue 3.',
                'price' => 249.00,
                'cover_image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
                'download_url' => 'https://example.com/downloads/vue-js-v-praxi.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Digitální produkty bez stresu',
                'author' => 'Martin Doležal',
                'description' => 'Jak připravit, prodávat a doručovat digitální produkty zákazníkům bez zbytečné administrativy.',
                'price' => 199.00,
                'cover_image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=900&q=80',
                'download_url' => 'https://example.com/downloads/digitalni-produkty-bez-stresu.pdf',
                'is_active' => true,
            ],
        ];

        foreach ($ebooks as $ebook) {
            Ebook::updateOrCreate(
                ['title' => $ebook['title']],
                $ebook
            );
        }
    }
}
