<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import Filter from "@/components/jobs/Filter.vue";
import Posts from "@/components/jobs/Posts.vue";
import {computed, ref} from "vue";
import type { BreadcrumbItem } from '@/types';

const props = defineProps({
    cities: {
        type:Array,
    },
    posts: {
        type: Object,
    },
    categories:{
        type:Array,
    },
    savedPost:{
        type:Array,
        default: () => [],
    },
    isPremium: {
        type: Boolean,
        default: false,
    },
})
const searchQuery = ref("");
const searchQueryPerformed = ref(false);
const sortBy = ref("");

const searchPosts = () => {
    searchQueryPerformed.value = true;
    router.get(route("jobs.index"), { search: searchQuery.value, sort: sortBy.value }, { preserveState: true });
};
// Handle pagination
const fetchPage = (url) => {
    if (url) {
        router.get(url, {sort: sortBy.value }, { preserveState: true });
    }
};
const pages = computed(() => {
    const pageNumbers = [];
    const totalPages = props.posts.last_page;
    const currentPage = props.posts.current_page;

    let startPage = currentPage - 2 > 0 ? currentPage - 2 : 1;
    let endPage = currentPage + 2 < totalPages ? currentPage + 2 : totalPages;

    for (let page = startPage; page <= endPage; page++) {
        pageNumbers.push(page);
    }

    return pageNumbers;
});

// Generate the URL for each page
const getPageUrl = (page) => {
    return `${props.posts.path}?page=${page}&sort=${sortBy.value}`;
};

const filterActive = ref(false);
const toggleFilter = () =>{
    filterActive.value = !filterActive.value;
}

const showPremiumModal = ref(false);
const openPremiumModal = () => {
    showPremiumModal.value = true;
};
const closePremiumModal = () => {
    showPremiumModal.value = false;
};

const selectedPlan = ref('1month');

const goToStripeCheckout = () => {
    window.location.href = `/stripe-checkout?plan=${selectedPlan.value}`;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Jobs',
        href: '/jobs.index',
    },
];

const page = usePage();
const userRole = page.props.auth && page.props.auth.user ? page.props.auth.user.role : null;

</script>

<template>
    <Head title="Jobs"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <div class="lg:pt-8 mr-4 lg:mr-16 lg:space-y-0 lg:flex lg:space-x-4 justify-end items-center">
                    <div class="flex space-x-2 justify-end">
                        <button class="block lg:hidden p-1.5 md:p-3 h-8 md:h-10 bg-gray-50 rounded-lg hover:bg-blue-600" @click="toggleFilter" type="button">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V17L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                        <select v-model="sortBy" @change="searchPosts" class="border w-fit md:w-36 border-gray-500 md:pl-4 text-xs md:text-sm rounded-lg md:p-1.5 h-8 md:h-10">
                            <option disabled  value="" selected>Sort by</option>
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="title-asc">Title (A-Z)</option>
                            <option value="title-desc">Title (Z-A)</option>
                            <option value="highest-paid">Highest Paid</option>
                            <option value="lowest-paid">Lowest Paid</option>
                        </select>
                        <button v-if="!props.isPremium" @click="openPremiumModal" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-lg px-4 h-8 md:h-10 text-xs md:text-sm transition-colors duration-200 flex items-center gap-1">
                            <span class="flex items-center justify-center gap-2">Premium
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001" xml:space="preserve" fill="#000000" class="w-8 h-8 mb-2">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                    <path style="fill:#ffffff;" d="M156.747,473.492c-9.848,0-24.225-4.823-56.16-40.565c-16.231-18.165-29.533-36.033-30.091-36.785 c-0.376-0.507-0.717-1.036-1.023-1.587c-6.073-10.932-9.283-23.321-9.283-35.828v-90.89c0-7.925,6.424-14.35,14.35-14.35h116.075 c16.624,0,32.305,6.421,44.155,18.081l59.435,58.485c17.218,17.218,17.218,45.102,0.083,62.239 c-0.026,0.026-0.146,0.145-0.171,0.169c-8.227,8.227-19.264,12.798-31.004,12.798c-11.739,0-22.777-4.572-31.078-12.873 l-59.37-59.372c-5.889-0.044-15.45-0.089-23.087-0.123l-10.867-0.052c-7.925-0.042-14.317-6.499-14.275-14.424 c0.042-7.899,6.457-14.275,14.348-14.275c0.026,0,0.05,0,0.076,0l10.85,0.052c6.784,0.03,14.038,0.065,19.604,0.099 c2.808,0.017,5.19,0.036,6.876,0.056c4.159,0.046,8.461,0.093,12.618,4.223l63.521,63.521c2.88,2.88,6.71,4.467,10.784,4.467 c4.075,0,7.905-1.586,10.785-4.467c0.026-0.026,0.146-0.145,0.171-0.169c5.873-5.873,5.873-15.549-0.075-21.496l-59.353-58.403 c-6.447-6.344-14.98-9.838-24.026-9.838H88.889v76.541c0,7.337,1.808,14.609,5.236,21.088c2.615,3.468,13.585,17.86,26.469,32.423 c25.476,28.797,35.211,32.208,36.505,32.554l155.149-0.03c10.576,0,22.902-5.538,34.621-11.21 c9.893-4.787,83.334-54.602,127.304-84.877c0.24-0.165,0.485-0.323,0.735-0.474c8.199-4.939,10.853-15.631,5.913-23.835 c-2.391-3.971-6.189-6.774-10.689-7.892c-4.415-1.096-8.989-0.441-12.91,1.842l-107.186,71.082 c-6.604,4.38-15.51,2.574-19.889-4.028c-4.381-6.605-2.577-15.51,4.029-19.89l107.483-71.28c0.172-0.115,0.349-0.227,0.527-0.333 c10.541-6.347,22.922-8.211,34.861-5.246c11.942,2.965,22.014,10.402,28.362,20.94c13.018,21.622,6.146,49.764-15.285,62.975 c-13.296,9.152-115.77,79.597-130.751,86.847c-14.716,7.122-30.476,14.076-47.12,14.076l-155.498,0.03 C156.752,473.492,156.749,473.492,156.747,473.492z"></path>
                                    <rect x="14.35" y="250.215" style="fill:#FEE187;" width="84.146" height="189.587"></rect>
                                    <path style="fill:#ffffff;" d="M98.49,454.142H14.35c-7.925,0-14.35-6.424-14.35-14.35V250.209c0-7.925,6.424-14.35,14.35-14.35 h84.14c7.925,0,14.35,6.424,14.35,14.35V439.79C112.84,447.716,106.415,454.142,98.49,454.142z M28.699,425.442H84.14V264.559 H28.699V425.442z"></path>
                                    <path style="fill:#FEE187;" d="M352.57,227.758l55.285,29.065c7.478,3.932,16.218-2.418,14.79-10.745l-10.558-61.561l44.726-43.597 c6.05-5.898,2.712-16.172-5.649-17.386l-61.811-8.981L361.711,58.54c-3.74-7.577-14.542-7.577-18.281,0l-27.643,56.009 l-61.811,8.981c-8.36,1.215-11.699,11.49-5.649,17.386l44.726,43.597l-10.558,61.561c-1.428,8.327,7.313,14.677,14.79,10.745 L352.57,227.758z"></path>
                                    <path style="fill:#ffffff;" d="M412.6,272.365c-3.935,0-7.885-0.983-11.422-2.841L352.57,243.97l-48.608,25.555 c-3.536,1.858-7.486,2.841-11.422,2.841l0,0c-7.244,0-14.096-3.2-18.802-8.781c-4.649-5.516-6.612-12.781-5.387-19.933l9.284-54.127 l-39.324-38.331c-6.739-6.569-9.118-16.209-6.211-25.159c2.909-8.95,10.5-15.351,19.813-16.704l54.345-7.897l24.304-49.245 c4.166-8.439,12.599-13.681,22.009-13.681c9.412,0,17.845,5.242,22.009,13.682l24.304,49.244l54.346,7.897 c9.311,1.353,16.902,7.753,19.811,16.704c2.909,8.95,0.528,18.59-6.209,25.159l-39.324,38.331l9.283,54.125 c1.227,7.15-0.736,14.416-5.385,19.932C426.699,269.165,419.845,272.365,412.6,272.365z M352.57,213.408 c2.295,0,4.586,0.55,6.677,1.649l47.832,25.145l-9.135-53.26c-0.798-4.655,0.746-9.405,4.127-12.701l38.697-37.719l-53.478-7.772 c-4.674-0.679-8.713-3.615-10.804-7.849L352.57,72.442L328.655,120.9c-2.091,4.235-6.13,7.171-10.804,7.849l-53.477,7.772 l38.697,37.718c3.381,3.298,4.925,8.046,4.127,12.702l-9.135,53.26l47.83-25.145C347.984,213.958,350.277,213.408,352.57,213.408z"></path>
                                    </g>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
        </div>

        <main class="md:mx-auto w-full  mt-2 md:p-8 lg:max-w-7xl xl:p-0">
            <div class="mx-auto">
                <div class="flex justify-center lg:justify-between md:gap-4 m-4">
                    <Filter id="filter" class="lg:block absolute lg:relative " :class="{'hidden' : !filterActive}" :cities="cities" :categories="categories"></Filter>
                    <section id="right" class="mx-auto md:w-full" >
                        <Posts :posts ="posts" :savedPost="savedPost" :searchQueryPerformed="searchQueryPerformed"/>

                        <div v-if="posts.data.length !== 0" class="flex justify-center mx-auto text-sm md:text-md md:space-x-2 my-3 md:my-6 bg-white w-60 md:w-fit py-1 md:py-2 px-3 md:px-6 rounded-full ">
                            <button
                                @click="fetchPage(posts.prev_page_url)"
                                class="pr-4 text-gray-900 "
                                :class="{'active': posts.prev_page_url, 'disabled': !posts.prev_page_url }"
                            >
                            <span class="flex items-center">
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                Previous
                            </span>

                            </button>

                            <div v-for="page in pages" :key="page" class="flex items-center ">
                                <Link :href="getPageUrl(page)"
                                      class=""
                                      @click.prevent="fetchPage(getPageUrl(page))">
                                <span   class=" flex items-center justify-center h-4 w-4 p-4 rounded-full leading-tight "
                                        :class="{'bg-indigo-600 text-white': page === posts.current_page, 'hover:bg-indigo-100': page !== posts.current_page}">
                                        {{ page }}
                                </span>
                                </Link>
                            </div>
                            <button
                                @click="fetchPage(posts.next_page_url)"
                                class="pl-4 text-gray-900 "
                                :class="{'active': posts.next_page_url, 'disabled': !posts.next_page_url }"
                            >
                            <span class="flex items-center">
                                Next
                                <svg viewBox="0 0 24 24" width="25px" height="25px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 7L15 12L10 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </span>
                            </button>
                        </div>
                    </section>
                </div>
            </div>
        </main>

    </AppLayout>

    <div v-if="showPremiumModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-8 mx-4 max-w-md w-full text-center relative" >
            <button @click="closePremiumModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none">&times;</button>
            <h2 class="text-xl text-blue-900 font-bold mb-4 flex items-center justify-center gap-2">
                Premium
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" viewBox="0 0 512.001 512.001" xml:space="preserve" class="w-10 h-10 mb-3">
                <path style="fill:#2D527C;" d="M156.747,473.492c-9.848,0-24.225-4.823-56.16-40.565c-16.231-18.165-29.533-36.033-30.091-36.785  c-0.376-0.507-0.717-1.036-1.023-1.587c-6.073-10.932-9.283-23.321-9.283-35.828v-90.89c0-7.925,6.424-14.35,14.35-14.35h116.075  c16.624,0,32.305,6.421,44.155,18.081l59.435,58.485c17.218,17.218,17.218,45.102,0.083,62.239  c-0.026,0.026-0.146,0.145-0.171,0.169c-8.227,8.227-19.264,12.798-31.004,12.798c-11.739,0-22.777-4.572-31.078-12.873  l-59.37-59.372c-5.889-0.044-15.45-0.089-23.087-0.123l-10.867-0.052c-7.925-0.042-14.317-6.499-14.275-14.424  c0.042-7.899,6.457-14.275,14.348-14.275c0.026,0,0.05,0,0.076,0l10.85,0.052c6.784,0.03,14.038,0.065,19.604,0.099  c2.808,0.017,5.19,0.036,6.876,0.056c4.159,0.046,8.461,0.093,12.618,4.223l63.521,63.521c2.88,2.88,6.71,4.467,10.784,4.467  c4.075,0,7.905-1.586,10.785-4.467c0.026-0.026,0.146-0.145,0.171-0.169c5.873-5.873,5.873-15.549-0.075-21.496l-59.353-58.403  c-6.447-6.344-14.98-9.838-24.026-9.838H88.889v76.541c0,7.337,1.808,14.609,5.236,21.088c2.615,3.468,13.585,17.86,26.469,32.423  c25.476,28.797,35.211,32.208,36.505,32.554l155.149-0.03c10.576,0,22.902-5.538,34.621-11.21  c9.893-4.787,83.334-54.602,127.304-84.877c0.24-0.165,0.485-0.323,0.735-0.474c8.199-4.939,10.853-15.631,5.913-23.835  c-2.391-3.971-6.189-6.774-10.689-7.892c-4.415-1.096-8.989-0.441-12.91,1.842l-107.186,71.082  c-6.604,4.38-15.51,2.574-19.889-4.028c-4.381-6.605-2.577-15.51,4.029-19.89l107.483-71.28c0.172-0.115,0.349-0.227,0.527-0.333  c10.541-6.347,22.922-8.211,34.861-5.246c11.942,2.965,22.014,10.402,28.362,20.94c13.018,21.622,6.146,49.764-15.285,62.975  c-13.296,9.152-115.77,79.597-130.751,86.847c-14.716,7.122-30.476,14.076-47.12,14.076l-155.498,0.03  C156.752,473.492,156.749,473.492,156.747,473.492z"/>
                <rect x="14.35" y="250.215" style="fill:#CEE8FA;" width="84.146" height="189.587"/>
                <path style="fill:#2D527C;" d="M98.49,454.142H14.35c-7.925,0-14.35-6.424-14.35-14.35V250.209c0-7.925,6.424-14.35,14.35-14.35  h84.14c7.925,0,14.35,6.424,14.35,14.35V439.79C112.84,447.716,106.415,454.142,98.49,454.142z M28.699,425.442H84.14V264.559  H28.699V425.442z"/>
                <path style="fill:#CEE8FA;" d="M352.57,227.758l55.285,29.065c7.478,3.932,16.218-2.418,14.79-10.745l-10.558-61.561l44.726-43.597  c6.05-5.898,2.712-16.172-5.649-17.386l-61.811-8.981L361.711,58.54c-3.74-7.577-14.542-7.577-18.281,0l-27.643,56.009  l-61.811,8.981c-8.36,1.215-11.699,11.49-5.649,17.386l44.726,43.597l-10.558,61.561c-1.428,8.327,7.313,14.677,14.79,10.745  L352.57,227.758z"/>
                <path style="fill:#2D527C;" d="M412.6,272.365c-3.935,0-7.885-0.983-11.422-2.841L352.57,243.97l-48.608,25.555  c-3.536,1.858-7.486,2.841-11.422,2.841l0,0c-7.244,0-14.096-3.2-18.802-8.781c-4.649-5.516-6.612-12.781-5.387-19.933l9.284-54.127  l-39.324-38.331c-6.739-6.569-9.118-16.209-6.211-25.159c2.909-8.95,10.5-15.351,19.813-16.704l54.345-7.897l24.304-49.245  c4.166-8.439,12.599-13.681,22.009-13.681c9.412,0,17.845,5.242,22.009,13.682l24.304,49.244l54.346,7.897  c9.311,1.353,16.902,7.753,19.811,16.704c2.909,8.95,0.528,18.59-6.209,25.159l-39.324,38.331l9.283,54.125  c1.227,7.15-0.736,14.416-5.385,19.932C426.699,269.165,419.845,272.365,412.6,272.365z M352.57,213.408  c2.295,0,4.586,0.55,6.677,1.649l47.832,25.145l-9.135-53.26c-0.798-4.655,0.746-9.405,4.127-12.701l38.697-37.719l-53.478-7.772  c-4.674-0.679-8.713-3.615-10.804-7.849L352.57,72.442L328.655,120.9c-2.091,4.235-6.13,7.171-10.804,7.849l-53.477,7.772  l38.697,37.718c3.381,3.298,4.925,8.046,4.127,12.702l-9.135,53.26l47.83-25.145C347.984,213.958,350.277,213.408,352.57,213.408z"/>
                </svg>
            </h2>
            <div class="mb-6 text-left text-gray-800 space-y-3">
                <ul class="list-disc pl-6 space-y-2">
                    <li>
                        See new jobs <span class="font-semibold text-blue-900">24 hours before</span> everyone else.
                    </li>
                    <li>
                        Your jobs are <span class="font-semibold text-blue-900">always at the top</span> of the list for maximum visibility.
                    </li>
                    <li>
                        A <span class="font-semibold text-blue-900">gold star</span> <span class="text-yellow-500 font-bold">★</span> highlights your premium status on your posts.
                    </li>
                </ul>
            </div>
            <div class="mb-6 flex flex-col items-center">
                <label class="block font-semibold mb-4 text-lg text-center w-full">Choose your plan:</label>
                <div class="flex flex-col md:flex-row gap-4 items-center justify-center w-full">
                    <label class="flex flex-col items-center bg-white border-2 border-indigo-200 rounded-2xl px-6 py-4 shadow-md cursor-pointer transition-all duration-200 hover:border-indigo-500 hover:shadow-lg w-56">
                        <input type="radio" value="1month" v-model="selectedPlan" class="accent-indigo-600 mb-2 scale-125" />
                        <span class="flex items-end font-bold text-indigo-700 text-lg h-8">
                <span class="text-2xl leading-none">1</span>
                <span class="text-sm align-bottom ml-1">month</span>
            </span>
                        <span class="text-gray-500 text-base">9.99€</span>
                    </label>
                    <label class="flex flex-col items-center bg-white border-2 border-indigo-200 rounded-2xl px-6 py-4 shadow-md cursor-pointer transition-all duration-200 hover:border-indigo-500 hover:shadow-lg w-56">
                        <input type="radio" value="6months" v-model="selectedPlan" class="accent-indigo-600 mb-2 scale-125" />
                        <span class="flex items-end font-bold text-indigo-700 text-lg h-8">
                <span class="text-2xl leading-none">6</span>
                <span class="text-sm align-bottom ml-1">months</span>
            </span>
                        <span class="text-gray-500 text-base">49.99€</span>
                    </label>
                    <label class="flex flex-col items-center bg-white border-2 border-indigo-200 rounded-2xl px-6 py-4 shadow-md cursor-pointer transition-all duration-200 hover:border-indigo-500 hover:shadow-lg w-56">
                        <input type="radio" value="1year" v-model="selectedPlan" class="accent-indigo-600 mb-2 scale-125" />
                        <span class="flex items-end font-bold text-indigo-700 text-lg h-8">
                <span class="text-2xl leading-none">1</span>
                <span class="text-sm align-bottom ml-1">year</span>
            </span>
                        <span class="text-gray-500 text-base">99.99€</span>
                    </label>
                </div>
            </div>
            <button
                @click="goToStripeCheckout"
                class="mt-8 mx-auto block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-3xl px-2 py-2 transition-colors duration-200 shadow-md">
                Get Premium
            </button>
        </div>
    </div>
</template>
