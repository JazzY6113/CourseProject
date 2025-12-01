<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::where('is_active', true)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('tour', compact('tours'));
    }

    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        $tours = Tour::with(['images', 'tourDates'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

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
            'images'
        ])->findOrFail($id);

        return view('tour-detail', compact('tour'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_group_size' => 'required|integer|min:1',
            'min_group_size' => 'nullable|integer|min:1',
            'booking_deadline_days' => 'nullable|integer|min:1',
            'included' => 'nullable|string',
            'not_included' => 'nullable|string',
            'requirements' => 'nullable|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (Tour::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $tourData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'base_price' => $validated['price'],
            'duration_days' => $validated['duration_days'],
            'max_group_size' => $validated['max_group_size'],
            'min_group_size' => $validated['min_group_size'] ?? 1,
            'booking_deadline_days' => $validated['booking_deadline_days'] ?? 7,
            'included' => $validated['included'] ? json_encode(explode("\n", $validated['included'])) : null,
            'not_included' => $validated['not_included'] ? json_encode(explode("\n", $validated['not_included'])) : null,
            'requirements' => $validated['requirements'] ? json_encode(explode("\n", $validated['requirements'])) : null,
            'is_active' => true,
        ];

        $tour = Tour::create($tourData);

        $this->createDefaultTourDates($tour);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('tour-images', 'public');

                TourImage::create([
                    'tour_id' => $tour->id,
                    'image_path' => $path,
                    'order_index' => $index,
                    'is_main' => $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.tours')->with('success', 'Тур успешно создан!');
    }

    private function createDefaultTourDates($tour)
    {
        $startDates = [
            now()->addDays(15),
            now()->addDays(30),
            now()->addDays(45),
            now()->addDays(60),
        ];

        foreach ($startDates as $index => $startDate) {
            $endDate = $startDate->copy()->addDays($tour->duration_days - 1);

            \App\Models\TourDate::create([
                'tour_id' => $tour->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'available_seats' => $tour->max_group_size,
                'current_price' => $tour->base_price * (1 + ($index * 0.1)),
                'is_guaranteed' => $index <= 1,
                'notes' => $index <= 1 ? 'Гарантированный departure' : null,
            ]);
        }
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        $tour = Tour::with('images')->findOrFail($id);
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        $tour = Tour::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'short_description' => 'sometimes|string|max:255',
            'full_description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'duration_days' => 'sometimes|integer|min:1',
            'max_group_size' => 'sometimes|integer|min:1',
            'min_group_size' => 'nullable|integer|min:1',
            'booking_deadline_days' => 'nullable|integer|min:1',
            'included' => 'nullable|string',
            'not_included' => 'nullable|string',
            'requirements' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [
            'title' => $validated['title'] ?? $tour->title,
            'short_description' => $validated['short_description'] ?? $tour->short_description,
            'full_description' => $validated['full_description'] ?? $tour->full_description,
            'base_price' => $validated['price'] ?? $tour->base_price,
            'duration_days' => $validated['duration_days'] ?? $tour->duration_days,
            'max_group_size' => $validated['max_group_size'] ?? $tour->max_group_size,
            'min_group_size' => $validated['min_group_size'] ?? $tour->min_group_size,
            'booking_deadline_days' => $validated['booking_deadline_days'] ?? $tour->booking_deadline_days,
            'is_active' => $validated['is_active'] ?? $tour->is_active,
        ];

        if (isset($validated['included'])) {
            $updateData['included'] = json_encode(explode("\n", $validated['included']));
        }
        if (isset($validated['not_included'])) {
            $updateData['not_included'] = json_encode(explode("\n", $validated['not_included']));
        }
        if (isset($validated['requirements'])) {
            $updateData['requirements'] = json_encode(explode("\n", $validated['requirements']));
        }

        $tour->update($updateData);

        if ($request->hasFile('images')) {
            foreach ($tour->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // Добавляем новые
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('tour-images', 'public');

                TourImage::create([
                    'tour_id' => $tour->id,
                    'image_path' => $path,
                    'order_index' => $index,
                    'is_main' => $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.tours')->with('success', 'Тур успешно обновлен!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
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
