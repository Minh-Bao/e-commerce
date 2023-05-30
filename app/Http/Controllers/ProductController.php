<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use nadar\quill\Lexer;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Pivots\ProductUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * Display a listing of the product.
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'products' => $this->getProductlistData()->take(20),
        ]);   
    }

    /**
     * Retrieve and add some info in nested arrays 
     * 
     * @template TMapValue   
     * @template TKey  *
     * @return Collection
     */
    private function getProductlistData(): Collection
    {
        $products = Product::all();
        return $products->map(function ( $product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'rating' => ceil($product->reviews->avg('rating')),
                'reviewCount' => $product->reviews->count(),
                'imageSrc' => $product->product_img_path,
                'imageAlt' => $product->image_alt,
            ];
        });
    }

    /**
     * Show product page
     *
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function show(Product $product, Request $request): Response
    {
        return Inertia::render('Products/Detail', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'product' => $this->getProductInfo($product),
            'reviews' => $this->getRatingsData($product),
            'featured'  => $this->getProductReviewsSorted($product, $request),
            'user'  => Auth::check() ? Auth::user() : null,
            'review_create_url' => route('review.create', $product->id),
            'countUserProduct' => Auth::check() ? ProductUser::where('user_id', Auth::user()->id)->count() : 0
        ]); 
    }

    /**
     * Retrieve ratings datas for the product 
     *
     * @param Product $product
     * @return array
     */
    private function getRatingsData(Product $product): array
    {
        return [
            'average'   => ceil($product->reviews->avg('rating')),
            'totalCount'=> $product->reviews->count(),
            'countRating_1' => $product->reviews()->rates(1),
            'countRating_2' => $product->reviews()->rates(2),
            'countRating_3' => $product->reviews()->rates(3),
            'countRating_4' => $product->reviews()->rates(4),
            'countRating_5' => $product->reviews()->rates(5),
        ];
    }

    /**
     * Retrieve product infos
     *
     * @param Product $product
     * @return array
     */
    private function getProductInfo(Product $product) : array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'product_img_path' => $product->product_img_path,
            'price' => $product->price,
            'in_stock' => $product->quantity > 0 ? true : false,
            'user_id' => $product->user_id,
            'created_at' => $product->created_at,            
        ];
    }


    /**
     * Retrieve all reviews from the product sorted and filtered
     *
     * @param Product $product
     * @param Request $request
     * @return Collection
     */
    public function getProductReviewsSorted(Product $product,Request $request ): Collection
    {       
        if( $request->sortDate){
            $reviews = $this->sortReviewsByDate($product, $request);
        } else if( $request->sortRate) {
            $reviews = $this->sortReviewsByRate($product, $request);
        }else if($request->rate){
            $reviews = $this->filterReviewsByRate($product, $request);
        }else{
            $reviews = $this->getReviews($product, $request);
        }  



        return $reviews->map(function ( $review) {
            $lexer = Str::isJson($review->review) ? new lexer($review->review) : null;
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'content' => isset($lexer) ? $lexer->render() : $review->review,
                'image_path' => $review->image_path ?? null,
                'author' => $this->getAuthorReview($review),
                'avatarSrc' => $review->user_id ? $review->user->profile_photo_path : url('app_img/avatar.svg'),
                'date'  => $review->created_at->format('Y-m-d h:i:s'),
            ];
        });
    }

    /**
     * Retrieve review's author name 
     *
     * @param [type] $review
     * @return string
     */
    private function getAuthorReview($review): string
    {
        if($review->user && empty($review->alias)){
            return $review->user->name;
        }else if( $review->alias){
            return $review->alias;
        }
        return "User : Anonymous";
    }

     /**
     * filter reviews By date
     *
     * @param Product $product
     * @param Request $request
     * @return LengthAwarePaginator  
     */
    private function filterReviewsByRate(Product $product, Request $request): LengthAwarePaginator  
    {
        return  $product->reviews()->where('rating',$request->rate)->orderBy('created_at', 'DESC')->paginate(10);
    }


    /**
     * Sort reviews By date
     *
     * @param Product $product
     * @param Request $request
     * @return LengthAwarePaginator  
     */
    private function sortReviewsByDate(Product $product, Request $request): LengthAwarePaginator  
    {
        return  $product->reviews()->orderBy('created_at',$request->sortDate)->paginate(10);
    }

    /**
     * Sort reviews By Rate
     *
     * @param Product $product
     * @param Request $request
     * @return LengthAwarePaginator  
     */
    private function sortReviewsByRate(Product $product, Request $request): LengthAwarePaginator  
    {
        return  $product->reviews()->orderBy('rating',$request->sortRate)->paginate(10);
    }

    /**
     * Get the reviews of the product
     *
     * @param Product $product
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function getReviews(Product $product, Request $request): LengthAwarePaginator
    {
        return  $product->reviews()->orderBy('created_at', 'desc')->paginate(10);
    }
}
