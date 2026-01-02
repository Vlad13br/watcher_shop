<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        $user = auth()->user();
        $watcherId = $request->watcher_id;

        // Перевіряємо, чи користувач вже залишав відгук
        $existingReview = DB::table('reviews')
            ->where('user_id', $user->id)
            ->where('watcher_id', $watcherId)
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'Ви вже залишили відгук для цього товару.');
        }

        // Додаємо новий відгук
        DB::table('reviews')->insert([
            'user_id' => $user->id,
            'watcher_id' => $watcherId,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'review_date' => now(),
        ]);

        // Очищуємо кеш відгуків для цього годинника
        Cache::forget('watcher_reviews_' . $watcherId);

        return redirect()
            ->route('watch.show', ['id' => $watcherId])
            ->with('success', 'Ваш відгук успішно додано.');
    }
}
