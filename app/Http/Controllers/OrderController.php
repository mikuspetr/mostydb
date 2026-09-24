<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.ebook_id' => ['required', 'integer', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $itemsById = collect($validated['items'])->keyBy('ebook_id');
        $ebooks = Ebook::query()
            ->active()
            ->whereIn('id', $itemsById->keys())
            ->get();

        if ($ebooks->count() !== $itemsById->count()) {
            throw ValidationException::withMessages([
                'items' => 'Vybraná e-kniha už není dostupná.',
            ]);
        }

        $preparedItems = $ebooks->map(function (Ebook $ebook) use ($itemsById) {
            $quantity = (int) $itemsById[$ebook->id]['quantity'];
            $unitPrice = (float) $ebook->price;
            $totalPrice = $unitPrice * $quantity;

            return [
                'ebook_id' => $ebook->id,
                'ebook_title' => $ebook->title,
                'quantity' => $quantity,
                'unit_price' => round($unitPrice, 2),
                'total_price' => round($totalPrice, 2),
                'download_url' => $ebook->download_url,
            ];
        });

        $order = DB::transaction(function () use ($validated, $preparedItems) {
            $order = Order::create([
                'order_number' => 'ORD-'.now()->format('YmdHis').'-'.str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'status' => 'paid',
                'total_price' => $preparedItems->sum('total_price'),
            ]);

            $order->items()->createMany(
                $preparedItems->map(fn (array $item) => [
                    'ebook_id' => $item['ebook_id'],
                    'ebook_title' => $item['ebook_title'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                ])->all()
            );

            return $order;
        });

        return response()->json([
            'message' => 'Objednávka byla úspěšně vytvořena.',
            'order_number' => $order->order_number,
            'total_price' => number_format((float) $order->total_price, 2, '.', ''),
            'downloads' => $preparedItems->map(fn (array $item) => [
                'title' => $item['ebook_title'],
                'download_url' => $item['download_url'],
            ])->values(),
        ], 201);
    }
}
