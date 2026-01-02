<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class WatcherController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'min_price' => $request->has('min_price') ? $request->min_price : '',
            'max_price' => $request->has('max_price') ? $request->max_price : '',
            'sort'      => $request->has('sort') ? $request->sort : '',
        ];

        session(['filters' => $filters]);

        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $cacheKey = 'watchers_' . md5(json_encode($filters) . "_page_" . $currentPage);

        $products = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($filters, $perPage, $currentPage) {
            $query = DB::table('watchers');

            if (!empty($filters['min_price'])) {
                $query->where('price', '>=', $filters['min_price']);
            }

            if (!empty($filters['max_price'])) {
                $query->where('price', '<=', $filters['max_price']);
            }

            switch ($filters['sort']) {
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }

            return $query->paginate($perPage);
        });

        return view('welcome', compact('products', 'filters'));
    }

    public function show($id)
    {
        $cacheKeyWatcher = 'watcher_show_' . $id;
        $cacheKeyReviews = 'watcher_reviews_' . $id;

        // Отримуємо сам годинник
        $watch = Cache::remember($cacheKeyWatcher, now()->addMinutes(10), function () use ($id) {
            return DB::table('watchers')->where('id', $id)->first();
        });

        // Отримуємо окремо відгуки
        $reviews = Cache::remember($cacheKeyReviews, now()->addMinutes(10), function () use ($id) {
            return DB::table('reviews')
                ->where('watcher_id', $id)
                ->orderBy('review_date', 'desc')
                ->get();
        });

        return view('watcher-page', compact('watch', 'reviews'));
    }
}
