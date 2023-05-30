
<template>
    <div class="bg-gray-50">
      <!-- Mobile menu -->
  
      <header class="relative bg-white">
        <p class="flex h-10 items-center justify-center bg-indigo-600 px-4 text-sm font-medium text-white sm:px-6 lg:px-8">Get free delivery on orders over $100</p>
        <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="border-b border-gray-200">
            <div class="flex h-16 items-center">
              <button type="button" class="rounded-md bg-white p-2 text-gray-400 lg:hidden" @click="open = true">
                <span class="sr-only">Open menu</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
              </button>
  
              <!-- Logo -->
              <div class="ml-4 flex lg:ml-0">
                <Link :href="route('welcome')">
                  <span class="sr-only">Fizzup</span>
                  <img class="h-8 w-auto" src="https://cdn.fizzup.com/full/landing_01/images/b/logo_header_web@2x.png" alt="" />
                </link>
              </div>
  
               <div v-if="canLogin" class="ml-auto flex items-center">

                <!-- Cart -->
                <div v-if="$page.props.auth.user" class="ml-4 flow-root lg:ml-6">
                  <Link  :href="route('dashboard')" class="group -m-2 flex items-center p-2">
                    <ShoppingBagIcon class="h-6 w-6 flex-shrink-0 text-indigo-400 group-hover:text-indigo-500" aria-hidden="true" />
                    <span class="ml-2 text-sm font-medium text-indigo-700 group-hover:text-indigo-800">0</span>
                    <span class="text-sm italic text-gray-400  p-2">items in cart</span>
                  </link>
                </div>
                
                    <div v-else  class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                        <Link  :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-gray-800">Sign in</link>
                            <span class="h-6 w-px bg-gray-200" aria-hidden="true" ></span>
                        <Link v-if="canRegister" :href="route('register')" class="text-sm font-medium text-gray-700 hover:text-gray-800">Create account</link>
                    </div>
              </div>
            </div>
          </div>
        </nav>
      </header>
  
      <main>
        <!-- Product -->
        <div class="bg-white">
          <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 sm:pb-32 sm:pt-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
            <!-- Product details -->
            <div class="lg:max-w-lg ">
  
              <div class="mt-4">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl capitalize">{{ product.name }}</h1>
              </div>
  
              <section aria-labelledby="information-heading" class="mt-4">
                <h2 id="information-heading" class=" text-gray-500 pb-2">Product information : </h2>
  
                <div class="flex items-center">
                  <p class="text-lg text-gray-900 sm:text-xl">{{ product.price }} <span class="italic">Euros</span></p>
  
                  <div class="ml-4 border-l border-gray-300 pl-4">
                    <h2 class="sr-only">Reviews</h2>
                    <div class="flex items-center">
                      <div>
                        <div class="flex items-center">
                          <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                        </div>
                        <p class="sr-only">{{ reviews.average }} out of 5 stars</p>
                      </div>
                      <p class="ml-2 text-sm text-gray-500">{{ reviews.totalCount }} reviews</p>
                    </div>
                  </div>
                </div>
  
                <div class="mt-4 space-y-6">
                  <p class="text-base text-gray-500 text-justify">{{ product.description }}</p>
                </div>
  
                <div  class="mt-6 flex items-center">
                    <div v-if="product.in_stock" class="flex" >
                        <CheckIcon class="h-5 w-5 flex-shrink-0 text-green-500" aria-hidden="true" />
                        <p class="ml-2 text-sm text-gray-500">In stock and ready to ship</p>
                    </div>
                    <div v-else class="flex">
                        <CheckIcon class="h-5 w-5 flex-shrink-0 text-green-500" aria-hidden="true" />
                        <p class="ml-2 text-sm text-gray-500">Product out of stock</p>
                    </div>

                </div>
              </section>
            </div>
  
            <!-- Product image -->
            <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
              <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
                <img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center" />
              </div>
            </div>
          </div>
        </div>

       <!--  Reviews -->
        <section aria-labelledby="reviews-heading" class="bg-white">
          <div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-2 lg:py-8">
            <div class="lg:col-span-4">
              <h2 id="reviews-heading" class="text-2xl font-bold tracking-tight text-gray-900">Customer Reviews</h2>
  
              <div class="mt-3 flex items-center">
                <div>
                  <div class="flex items-center">
                    <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                  </div>
                  <p class="sr-only">{{ reviews.average }} out of 5 stars</p>
                </div>
                <p class="ml-2 text-sm text-gray-900">Based on {{ reviews.totalCount }} reviews</p>
              </div>
  
              <div class="mt-6">
                <h3 class="sr-only">Review data</h3>
  
                <dl class="space-y-3">
                  <div v-for="count in reviews.counts" :key="count.rating" class="flex items-center text-sm">
                    <dt class="flex flex-1 items-center">
                      <p class="w-3 font-medium text-gray-900">{{ count.rating }}<span class="sr-only"> star reviews</span></p>
                      <div aria-hidden="true" class="ml-1 flex flex-1 items-center">
                        <StarIcon :class="[count.count > 0 ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
  
                        <div class="relative ml-3 flex-1">
                          <div class="h-3 rounded-full border border-gray-200 bg-gray-100" />
                          <div v-if="count.count > 0" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400" :style="{ width: `calc(${count.count} / ${reviews.totalCount} * 100%)` }" />
                        </div>
                      </div>
                    </dt>
                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">{{ Math.round((count.count / reviews.totalCount) * 100) }}%</dd>
                  </div>
                </dl>
              </div>
  
              <div class="mt-10">
                <h3 class="text-lg font-medium text-gray-900">Share your thoughts</h3>
                <p class="mt-1 text-sm text-gray-600">If you’ve used this product, share your thoughts with other customers</p>
                <FormReviewModal :product="product" :review_create_url="review_create_url" :user="user" />
            </div>
            </div>

            <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
                <div class="flow-root">
                    <div class="-my-12 divide-y divide-gray-200">
                        <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
                            <div class="flex  justify-between ">
                                
                                <button @click="sortByRate" class="flex mt-8 ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                    </svg>
                                    <p class="text-sm  text-indigo-800 italic ">Ratings</p>
                                </button>

                                <div class="flex flex-col">
                                    <label class="text-sm  text-indigo-800 italic pb-2" for="rate">Sort reviews by rating</label>
                                    <select name="rate" id="rate" class="border-2 border-gray-200 h-8 rounded-lg">
                                        <option value="" selected>-----</option>
                                        <option v-for="i in [1,2,3,4,5]" :key="i" @click="filterByRate(i)" :value="i+1">{{i}}</option>
                                    </select>
                                </div>
                                
                                <button @click="sortByDate" class="flex mt-8 ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                    </svg>
                                    <p class="text-sm  text-indigo-800 italic ">Date</p>
                                </button>

                            </div>
                            <h3 class="py-4 text-center border border-gray-300 m-4 round">
                                Recent reviews
                            </h3>
                            <ReviewsList :featured="featured" :key="reviewOrder"/>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </section>
      </main>
  
    </div>
  </template>
  
  <script setup>
import { ref, Teleport } from "vue";
import {
    Dialog,
    DialogPanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    Bars3Icon,
    MagnifyingGlassIcon,
    ShieldCheckIcon,
    ShoppingBagIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import {
    CheckIcon,
    QuestionMarkCircleIcon,
    StarIcon,
} from "@heroicons/vue/20/solid";
import Layout from "@/Layouts/AppLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ReviewsList from "@/Components/ReviewsList.vue";
import FormReviewModal from "@/Components/FormReviewModal.vue";

const data = defineProps([
    'user',
    "featured",
    "reviews",
    "product",
    "canLogin",
    "canRegister",
    "sort",
    "review_create_url",
]);

const user = data.user

const product = {
    id : data.product.id,
    name: data.product.name,
    href: "#",
    price: data.product.price,
    description: data.product.description,
    imageSrc: data.product.product_img_path,
    in_stock: data.product.in_stock,
    imageAlt: data.product.image_alt,
};
const reviews = {
    average: data.reviews.average,
    totalCount: data.reviews.totalCount,
    counts: [
        { rating: 5, count: data.reviews.countRating_5 },
        { rating: 4, count: data.reviews.countRating_4 },
        { rating: 3, count: data.reviews.countRating_3 },
        { rating: 2, count: data.reviews.countRating_2 },
        { rating: 1, count: data.reviews.countRating_1 },
    ],
};

var reviewOrder = 0;

const urlParams = new URLSearchParams(window.location.search);

function sortBy(type) {
    return urlParams.has(type) && urlParams.get(type) === "asc" ? "desc" : "asc";
}
function hasParam(type) {
    return urlParams.has(type) ? urlParams.get(type) : "asc";
}
function sortByDate() {
    router.visit( 
        "/products/" + product.id + "/show?sortDate=" + sortBy("sortDate"), 
        { 
            only: ["featured"],
            preserveScroll: true,        
        } 
        
    );
    reviewOrder +=  1
}
function sortByRate() {
    router.visit(
         "/products/" + product.id + "/show?sortRate=" + sortBy("sortRate"), 
        { 
            only: ["featured"],
            preserveScroll: true
        }
    );
    reviewOrder +=  1
}

function filterByRate(rate) {
    router.visit(
         "/products/" + product.id + "/show?rate=" + rate , 
        { 
            only: ["featured"],
            preserveScroll: true
        }
    );
    reviewOrder +=  1
}



</script>