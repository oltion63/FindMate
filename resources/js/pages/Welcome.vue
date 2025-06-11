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

        <section class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 py-8 px-4 border-t bg-white border-gray-400 border-b">
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

        <!-- Feature Image & Call to Action -->
        <!-- Feature Image & Call to Action -->
        <section class="py-16 px-6 bg-white">
            <div class="max-w-screen-xl mx-auto grid md:grid-cols-2 gap-10 items-center">

                <!-- Image -->
                <img class="w-full rounded-xl shadow-xl" :src="'/storage/images/jobSearch.png'" alt="dashboard image" />

                <!-- Text Block with Black Background -->
                <div class="bg-[#111111] text-[#F6F6F6] p-8 rounded-3xl shadow-lg">
                    <h2 class="text-4xl font-extrabold mb-4 text-[#FFCB74]">
                        Join our platform today and connect with top employers!
                    </h2>
                    <p class="mb-6 text-lg leading-relaxed">
                        FindJob lets you discover exciting career opportunities, apply with ease, and take the next step toward your dream job.
                    </p>
                    <Link
                        :href="route('jobs.index')"
                        class="inline-flex items-center gap-2 px-6 py-3 text-[#111111] font-bold bg-[#FFCB74] rounded-full hover:bg-[#e6b864] transition duration-200 shadow"
                    >
                        Get started
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </Link>
                </div>

            </div>
        </section>


        <!-- Partners -->
        <section class="border-t border-gray-300 py-12 bg-white text-center">
            <h3 class="inline-block px-6 py-2 mb-8 text-2xl font-extrabold tracking-wide text-[#111111] uppercase bg-white rounded-md ">
                Our Partners
            </h3>
            <div class="max-w-6xl mx-auto px-4">
                <PartnerBanner />
            </div>
        </section>



        <!-- Footer -->
        <Footer id="footer" />
    </div>
</template>
