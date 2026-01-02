<?php

namespace App\Http\Controllers;

use App\Models\Watcher;
use App\Http\Requests\WatcherRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $users = Cache::remember('admin_users', now()->addMinutes(10), function () {
            return DB::table('users')->get();
        });

        return view('admin.users', compact('users'));
    }

    public function createWatcher()
    {
        $this->authorize('create', Watcher::class);

        return view('admin.watchers.create');
    }

    public function storeWatcher(WatcherRequest $request)
    {
        $this->authorize('create', Watcher::class);

        DB::table('watchers')->insert([
            'product_name' => $request->input('product_name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'material' => $request->input('material'),
            'brand' => $request->input('brand'),
            'stock' => $request->input('stock'),
            'image_url' => $request->input('image_url'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::flush();

        return redirect('/dashboard')
            ->with('success', 'Годинник успішно додано!');
    }

    public function edit($watcher_id)
    {
        $watcher = Cache::remember("watcher_{$watcher_id}", now()->addMinutes(10), function () use ($watcher_id) {
            return DB::table('watchers')->where('id', $watcher_id)->first();
        });

        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        return view('admin.watchers.edit', compact('watcher'));
    }


    public function updateWatcher(WatcherRequest $request, $watcher_id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        DB::table('watchers')->where('id', $watcher_id)->update($request->validated() + ['updated_at' => now()]);

        Cache::forget("watcher_{$watcher_id}");
        Cache::forget('watchers');

        return redirect('/')
            ->with('success', 'Годинник успішно оновлено!');
    }

}
