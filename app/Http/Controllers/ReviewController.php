<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display the reviews page with approved reviews.
     */
    public function index()
    {
        $reviews = Review::approved()
            ->with(['user', 'tour'])
            ->orderBy('created_at', 'desc')
            ->get();

        $tours = Tour::where('is_active', true)->get();

        return view('reviews', compact('reviews', 'tours'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        $tours = Tour::where('is_active', true)->get();
        return view('reviews-create', compact('tours'));
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'author_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Если пользователь авторизован, используем его данные
        $userId = Auth::id();
        $authorName = $userId ? null : $request->author_name;

        // Проверяем, не оставлял ли пользователь уже отзыв на этот тур
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

    /**
     * Display the admin reviews management page.
     */
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

    /**
     * Approve a review.
     */
    public function approve($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $review = Review::findOrFail($id);
        $review->update(['status' => 'approved']);

        return back()->with('success', 'Отзыв опубликован.');
    }

    /**
     * Reject a review.
     */
    public function reject($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $review = Review::findOrFail($id);
        $review->update(['status' => 'rejected']);

        return back()->with('success', 'Отзыв отклонен.');
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещен');
        }

        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Отзыв удален.');
    }

    /**
     * Get reviews for a specific tour (for API)
     */
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
