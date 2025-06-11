<script setup lang="ts">
import {Head, Link, useForm} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import JobDetails from "@/components/jobs/JobDetails.vue";
import JobsCompanyDetails from "@/components/jobs/JobsCompanyDetails.vue";
import {ref} from "vue";
import ApplyModal from "@/pages/jobs/ApplyModal.vue";
import AboutCompanyModal from "@/components/jobs/AboutCompanyModal.vue";
import ReportModal from '@/pages/jobs/ReportModal.vue';
import type { BreadcrumbItem } from '@/types/index.js';

const props = defineProps({
    post: {
        type: Object,
    },
    user: {
        type: Object,
    },
    savedPost: {
        type: Number,
    }
})
const isApplyModalVisible = ref(false);
const updateApplyModalVisibility = (value) => {
    isApplyModalVisible.value = value;
};
const closeModal = () => {
    isApplyModalVisible.value = false;
};

const isReportModalVisible = ref(false);
const updateReportModalVisibility = (value) => {
    isReportModalVisible.value = value;
};
const closeReportModal = () => {
    isReportModalVisible.value = false;
};



const isACModalVisible = ref(false);
const updateACModalVisibility = (value) => {
    isACModalVisible.value = value;
};
const closeACModal = () => {
    isACModalVisible.value = false;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.post.tittle,
        href: '/jobs.index',
    },
];

</script>

<template>
    <Head :title="post.tittle"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <main class="mx-4 pb-4">
            <div class="flex justify-between mx-8 items-end lg:mt-16">
                <Link
                    :href="route('jobs.index')"
                    class="w-fit flex"
                >
                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-6 w-6 md:w-10 md:h-10" viewBox="0 0 869.959 869.958" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M146.838,484.584c10.271,10.395,23.804,15.6,37.347,15.6c13.329,0,26.667-5.046,36.897-15.155 c20.625-20.379,20.825-53.62,0.445-74.245l-41.688-42.191h423.78c88.963,0,161.34,72.376,161.34,161.339v4.32 c0,43.096-16.782,83.61-47.255,114.084c-20.503,20.502-20.503,53.744,0,74.246c10.251,10.251,23.688,15.377,37.123,15.377 c13.435,0,26.872-5.125,37.123-15.377c50.305-50.306,78.009-117.188,78.009-188.331v-4.32c0-71.142-27.704-138.026-78.009-188.331 c-50.306-50.305-117.189-78.009-188.331-78.009h-424.99l42.25-41.747c20.625-20.379,20.825-53.62,0.445-74.245 c-20.376-20.624-53.618-20.825-74.244-0.445L15.601,277.068c-9.905,9.787-15.517,23.107-15.6,37.03 c-0.084,13.924,5.367,27.31,15.154,37.215L146.838,484.584z"></path> </g> </g></svg>
                </Link>
                <Link
                    :href="route('jobs.edit', {id: post.id} )"
                    v-if="post.user_id === $page.props.auth.user.id"
                    class="text-blue-600 text-lg lg:text-xl font-bold"
                >
                    Edit
                </Link>
            </div>
            <div class="mx-auto bg-white rounded-lg lg:flex p-4">
                <JobDetails :post="post" :savedPost="savedPost" :isApplyModalVisible="isApplyModalVisible" @update:isApplyModalVisible="updateApplyModalVisibility" />
                <JobsCompanyDetails :post="post" :isACModalVisible="isACModalVisible" @update:isACModalVisible="updateACModalVisibility"/>
            </div>
            <div class="w-full flex justify-center">
                <button
                    @click="isReportModalVisible = true"
                    class="py-2 px-6 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition duration-300 ease-in-out"
                >
                    Report
                </button>
            </div>
            <ReportModal v-if="isReportModalVisible" :post="post" @close="closeReportModal"/>
            <AboutCompanyModal v-if="isACModalVisible" @close="closeACModal" :post="post" />
            <ApplyModal v-if="isApplyModalVisible" @close="closeModal" :user="user"  :post="post"/>
        </main>
    </AppLayout>
</template>
