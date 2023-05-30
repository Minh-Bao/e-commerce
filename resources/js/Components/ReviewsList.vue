<template>
    <div class="flow-root">
        <div class="-my-12 divide-y divide-gray-200">
            <div v-for="review in featured" :key="review.id" class="py-12">
                <div class="flex items-center">
                    <img
                        :src="review.avatarSrc"
                        :alt="`${review.author}.`"
                        class="h-12 w-12 rounded-full"
                    />
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-gray-900">
                            {{ review.author }}
                        </h4>
                        <div class="mt-1 flex items-center">
                            <StarIcon
                                v-for="rating in [0, 1, 2, 3, 4]"
                                :key="rating"
                                :class="[
                                    review.rating > rating
                                        ? 'text-yellow-400'
                                        : 'text-gray-300',
                                    'h-5 w-5 flex-shrink-0',
                                ]"
                                aria-hidden="true"
                            />
                        </div>
                        <p class="sr-only">
                            {{ review.rating }} out of 5 stars
                        </p>
                    </div>
                </div>
                <div
                    class="mt-4 space-y-6 text-base italic text-gray-600"
                    v-html="review.content">
                </div>
                <div class="image_review">
                    <img :src="review.image_path" :alt="'picture from ' + review.author + ' review'"  class="w-1/2" />
                </div>
                <div class="pt-2 italic text-sm flex justify-end text-gray-500">
                    {{ review.date }}
                </div>
                
            </div>
        </div>
    </div>

    <div v-if="!featured.length" class="text-center">
        <p class="text-sm font-medium text-gray-500">
            No reviews yet.
        </p>
    </div>
</template>


<script setup>
import Layout from "@/Layouts/AppLayout.vue";
import {
    CheckIcon,
    QuestionMarkCircleIcon,
    StarIcon,
} from "@heroicons/vue/20/solid";
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";

defineProps(["featured"]);

</script>