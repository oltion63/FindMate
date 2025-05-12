<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3';
import FirstText from "@/components/dashboard/FirstText.vue";
import Footer from "@/components/dashboard/Footer.vue";
import NavBar from "@/components/dashboard/NavBar.vue";
import PartnerBanner from "@/components/dashboard/PartnerBanner.vue";
import Card from "@/components/dashboard/Card.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome"/>
    <div class="min-h-screen bg-white">
        <NavBar/>
        <FirstText/>

        <section class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 py-8 px-4 border-t border-gray-400 border-b">
            <card>
                <template v-slot:numri>
                    50+
                </template>
                <template v-slot:heading>
                    More than 50 trusted
                </template>
                <template v-slot:p>
                    companies
                </template>
                <template v-slot:b>
                    and partners
                </template>
            </card>

            <card>
                <template v-slot:numri>
                    20+
                </template>
                <template v-slot:heading>
                    More than 20 new Job
                </template>
                <template v-slot:p>
                    postings
                </template>
                <template v-slot:b>
                    everyday
                </template>
            </card>
            <card>
                <template v-slot:numri>
                    20+
                </template>
                <template v-slot:heading>
                    More than 20 new
                </template>
                <template v-slot:p>
                    applications
                </template>
                <template v-slot:b>
                    everyday
                </template>
            </card>
            <card>
                <template v-slot:numri>
                    50+
                </template>
                <template v-slot:heading>
                    More than 50 new
                </template>
                <template v-slot:p>
                    users
                </template>
                <template v-slot:b>
                    every week
                </template>
            </card>

        </section>

        <section class="">
            <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                <img class="w-full height:70vh" :src="'storage/images/jobSearch.png'" alt="dashboard image">
                <div class="mt-4 md:mt-0">
                    <h2 class="mb-4 text-4xl tracking-tight font-extra-bold text-gray-900 ">Join our platform today and connect with top employers!</h2>
                    <p class="mb-6 font-light text-gray-700 md:text-lg">FindJob lets you discover exciting career opportunities, apply with ease, and take the next step toward your dream job.</p>
                    <Link
                        :href="route('jobs.index')"
                        class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border-b border-gray-700  hover:scale-x-110 transition   "
                    >
                        Get started
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </Link>
                </div>
            </div>

        </section>
        <section>
            <div class="flex  justify-center border-t border-gray-400 text-xl py-4">
                <span class="my-4">OUR PARTNERS</span>

            </div>
        </section>
        <partner-banner/>



        <Footer id="footer"/>


    </div>
</template>
