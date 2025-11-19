<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::approved()
            ->with(['user', 'tour'])
            ->orderBy('created_at', 'desc')
            ->get();

        $tours = Tour::where('is_active', true)->get();

        return view('reviews', compact('reviews', 'tours'));
    }

    public function create()
    {
        $tours = Tour::where('is_active', true)->get();
        return view('reviews-create', compact('tours'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'author_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $authorName = $userId ? null : $request->author_name;

        if ($userId) {
            $existingReview = Review::where('user_id', $userId)
                ->where('tour_id', $request->tour_id)
                ->first();

            if ($existingReview) {
                return back()->with('error', 'Вы уже оставляли отзыв на этот тур.');
            }
        }

        Review::create([
            'user_id' => $userId,
            'tour_id' => $request->tour_id,
            'author_name' => $authorName,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // На модерации
        ]);

        return redirect()->route('reviews')->with('success', 'Отзыв отправлен на модерацию. Спасибо!');
    }

    public function adminIndex()
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $pendingReviews = Review::pending()
            ->with(['user', 'tour'])
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedReviews = Review::approved()
            ->with(['user', 'tour'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    public function approve($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $review = Review::findOrFail($id);
        $review->update(['status' => 'approved']);

        return back()->with('success', 'Отзыв опубликован.');
    }

    public function reject($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $review = Review::findOrFail($id);
        $review->update(['status' => 'rejected']);

        return back()->with('success', 'Отзыв отклонен.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Отзыв удален.');
    }

    public function getTourReviews($tourId)
    {
        $reviews = Review::approved()
            ->where('tour_id', $tourId)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }
}
