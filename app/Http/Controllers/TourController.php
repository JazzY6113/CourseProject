<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::where('is_active', true)
            ->with(['images', 'tourDates' => function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date');
            }])
            ->get();

        return view('tour', compact('tours'));
    }

    public function adminIndex()
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $tours = Tour::with(['images', 'tourDates'])->get();
        return view('admin.tours.index', compact('tours'));
    }

    public function show($id)
    {
        $tour = Tour::with([
            'tourDates' => function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date');
            },
            'tourDates.tourDateStatus',
            'images'
        ])->findOrFail($id);

        return view('tour-detail', compact('tour'));
    }

    public function create()
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'booking_deadline' => 'required|date',
            'duration_days' => 'required|integer|min:1',
            'max_group_size' => 'required|integer|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $tour = Tour::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('tour-images', 'public');

                TourImage::create([
                    'tour_id' => $tour->id,
                    'image_path' => $path,
                    'order_index' => $index,
                ]);
            }
        }

        return redirect()->route('admin.tours')->with('success', 'Тур успешно создан!');
    }

    public function edit($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $tour = Tour::with('images')->findOrFail($id);
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $tour = Tour::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'short_description' => 'sometimes|string|max:255',
            'full_description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'booking_deadline' => 'sometimes|date',
            'is_active' => 'sometimes|boolean',
            'duration_days' => 'sometimes|integer|min:1',
            'max_group_size' => 'sometimes|integer|min:1',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $tour->update($validated);

        if ($request->hasFile('images')) {
            foreach ($tour->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('tour-images', 'public');

                TourImage::create([
                    'tour_id' => $tour->id,
                    'image_path' => $path,
                    'order_index' => $index,
                ]);
            }
        }

        return redirect()->route('admin.tours')->with('success', 'Тур успешно обновлен!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $tour = Tour::findOrFail($id);

        foreach ($tour->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $tour->delete();

        return redirect()->route('admin.tours')->with('success', 'Тур успешно удален!');
    }
}
