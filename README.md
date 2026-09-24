# MostyDB Ebook Shop

Jednoduchý eshop pro prodej ebooků postavený na Laravelu a Vue.js.

## Funkce

- veřejný katalog ebooků na `/`
- Vue.js košík s okamžitým přepočtem ceny
- jednoduchý checkout se jménem a e-mailem zákazníka
- uložení objednávky do databáze včetně položek
- ukázková seed data se třemi ebooky

## Spuštění

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

## Testování

```bash
php artisan test
npm run build
```
