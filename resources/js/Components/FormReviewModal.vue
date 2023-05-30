<template>
    <button
        @click="open = true"
        class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full"
    >
        Write a review
    </button>

    <!-- Main modal -->
    <Teleport to="body">
        <div
            v-if="open"
            class="modal space-y-10 divide-y divide-gray-900/10 bg-gray-200 p-4 rounded-xl"
        >
            <form @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2
                            class="text-base font-semibold leading-7 text-gray-900"
                        >
                            Write a review
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            This information will be displayed publicly so be
                            careful what you share. <br>
                            <span class="font-bold">Logged user: You can put an alias instaed of your name but if you don't fill the input your username will be displayed.  <br>
                            <span class="text-blue-400">For not logged user alias and email is required !</span>
                            </span>
                            
                        </p>

                        <div
                            class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                        >
                        <div class="sm:col-span-4">
                                <label for="alias" class="block text-sm font-medium leading-6 text-gray-900" >
                                    Rating
                                </label                               
                                >
                                <div class="mt-2">
                                    <span
                                        class=""
                                    >
                                        <select v-model="form.rating"  name="rating" id="rating" class="rounded-xl shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            <option value="" selected>-----</option>
                                            <option v-for="i in  [1,2,3,4,5]" :key="i" :value="i">{{ i }}</option>
                                        </select>
                                        <div class="text-red-500" v-if="form.errors.rating">{{ form.errors.rating }}</div>
                                    </span>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="alias" class="block text-sm font-medium leading-6 text-gray-900" >
                                    Alias
                                </label                               
                                >
                                <div class="mt-2">
                                    <div
                                        class=" rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md"
                                    >
                                        <input
                                            v-model="form.alias"
                                            type="text"
                                            name="alias"
                                            id="alias"
                                            :autocomplete=" user ?user.name : 'alias' "
                                            :placeholder="user ? user.name : 'alias' "
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        />
                                        <div class="text-red-500" v-if="form.errors.alias">{{ form.errors.alias }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label
                                    for="email"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Email address</label
                                >
                                <div class="mt-2">
                                    <input
                                        v-model="form.email"
                                        id="email"
                                        name="email"
                                        type="text"
                                        :autocomplete="user ? user.email : 'email'"
                                        :placeholder="user ? user.email : 'email' "
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    />
                                    <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
                                </div>
                            </div>

                            
                            <div class="col-span-full">

                                <label
                                    for="review"
                                    class="block text-sm font-medium leading-6 text-gray-900">
                                    review
                                </label>
                                <div class="mt-2">
                                    <QuillEditor
                                    v-model:content="form.review"
                                    id="review"
                                    name="review"
                                    theme="snow"
                                    rows="10"
                                    class="block bg-gray-100 w-full  py-1.5 text-gray-900 shadow-sm mb-8  sm:text-sm sm:leading-6"
                                     />
                                    <div class="text-red-500" v-if="form.errors.review">{{ form.errors.review }}</div>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">
                                   Please write your review here
                                </p>
                            </div>


                            <div class="col-span-full">
                                <label
                                    for="cover-photo"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    >Add image</label
                                >
                                <div
                                    class="mt-2 flex justify-center rounded-lg bg-gray-50 border border-dashed border-gray-900/25 px-6 py-10"
                                >
                                    <div class="text-center">
                                        <div
                                            class="mt-4 flex text-sm leading-6 text-gray-600"
                                        >
                                            <label
                                                for="image_path"
                                                class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                            >
                                                <span>Upload a image</span>
                                                <input
                                                    id="image_path"
                                                    name="image_path"
                                                    type="file"
                                                    class="sr-only"
                                                    @input="form.image_path = $event.target.files[0]"
                                                />
                                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                    {{ form.progress.percentage }}%
                                                </progress>
                                                <div class="text-red-500" v-if="form.errors.image_path">{{ form.errors.image_path }}</div>
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p
                                            class="text-xs leading-5 text-gray-600"
                                        >
                                            PNG, JPG, JPEG, GIF up to 10MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button
                        ref="closeModal"
                        @click="open = false"
                        type="button"
                        class="text-sm font-semibold leading-6 text-gray-900"
                    >
                        Close
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </Teleport>
 </template>
 <script setup>
 import { ref, Teleport } from "vue";
 import { useForm } from '@inertiajs/vue3';
 import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';



const data = defineProps(['review_create_url','product', 'user', 'editor'])

const product = data.product
const user = data.user

const form = useForm({
     email: null,
     alias: null,
     rating: 0,
     review: null,
     image_path: null,
     rating: null,
     product_id: product.id,
     user_id: user ? user.id : null,
 });

 
function submit(e) {
    form.transform((data) => ({...data,
    review: data.review ? JSON.stringify(form.review, null, +1) : '',
  })).submit('post', data.review_create_url, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: (e) => { 
                alert('Thank you for your feedback !')
                form.reset()
        },
     })
}

const open = ref(false);

 </script>

<style scoped>
.modal {
    overflow-y: auto;
    max-height: 500px;
    position: fixed;
    z-index: 999;
    top: 15%;
    left: 30%;
    width: 700px;
}
</style>