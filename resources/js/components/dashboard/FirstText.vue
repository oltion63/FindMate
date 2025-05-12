<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
</script>
<template>
    <section>
        <div class="grid max-w-screen-xl px-4 py-24 mx-auto lg:gap-8 xl:gap-0 lg:py-24 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl font-mono text-gray-900 ">Looking For A Job?</h1>
                <p class="max-w-2xl mb-6 font-light text-gray-700 lg:mb-8 md:text-lg lg:text-xl">Create your account today and let`s get started!</p>
                <Link
                    :href="route('register')"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border-b border-gray-700 hover:scale-x-110 transition   "
                >
                    Get started
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </Link>

            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex justify-end">
                <img :src="'storage/images/confusion.png'" alt="findJob">
            </div>
        </div>
        <div class="w-full hidden lg:flex justify-center pb-14">
            <svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M49.288,59.647c0.383,0.348,0.863,0.519,1.342,0.519c0.076,0,0.151-0.015,0.228-0.023c0.028,0.001,0.057,0.008,0.085,0.008 c0.545,0,1.088-0.222,1.482-0.657l15.231-16.804c0.742-0.818,0.68-2.083-0.139-2.824c-0.818-0.743-2.083-0.679-2.824,0.139 L50.656,55.49L35.169,41.453c-0.819-0.744-2.083-0.68-2.824,0.139c-0.742,0.818-0.68,2.083,0.139,2.824L49.288,59.647z"></path> <path d="M50,83.214c18.449,0,33.458-15.009,33.458-33.457c0-18.449-15.009-33.458-33.458-33.458 c-18.448,0-33.457,15.009-33.457,33.458C16.543,68.205,31.552,83.214,50,83.214z M50,20.299c16.243,0,29.458,13.215,29.458,29.458 c0,16.242-13.215,29.457-29.458,29.457c-16.242,0-29.457-13.215-29.457-29.457C20.543,33.514,33.758,20.299,50,20.299z"></path> </g> </g></svg>
        </div>
    </section>
</template>
