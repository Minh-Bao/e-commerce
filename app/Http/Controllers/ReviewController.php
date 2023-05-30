<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
   
    /**
     * Store a newly created review
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        $review = Review::create($validated);
        $this->uploadImg($review,$validated, $request);

        return to_route('product.show', $request->product_id)->with('Message', 'Review and image upload successfully');
    }

    /**
     * Upload file img to the designated folder
     *
     * @param Review $review
     * @param array $validated
     * @param StoreReviewRequest $request
     * @return void
     */
    private function uploadImg(Review $review, array $validated, StoreReviewRequest $request): void
    {
        Storage::disk("public_upload")->delete("image/review/".$review->image);
        $filename = now()->format('Y-m-d')."_" .$validated['image_path']->getClientOriginalName();
        $request->image_path->move(public_path("image/review"),$filename);
        $review->update(['image_path' => url('/'). '/image/review/'. $filename]);
    }
}
