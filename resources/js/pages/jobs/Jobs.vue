<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Jobs',
        href: '/jobs.index',
    },
];

</script>

<template>
    <Head title="Jobs"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <div class="pt-8 mr-16 lg:space-y-0 lg:flex lg:space-x-4 justify-end items-center">
                    <div class="flex space-x-2">
                        <select v-model="sortBy" @change="searchPosts" class="border w-fit md:w-36 border-gray-500 md:pl-4 text-xs md:text-sm rounded-lg md:p-1.5 h-8 md:h-10">
                            <option disabled  value="" selected>Sort by</option>
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="title-asc">Title (A-Z)</option>
                            <option value="title-desc">Title (Z-A)</option>
                            <option value="highest-paid">Highest Paid</option>
                            <option value="lowest-paid">Lowest Paid</option>
                        </select>
                    </div>
                </div>
        </div>

        <main class="md:mx-auto mt-2 md:p-4 lg:max-w-7xl xl:p-0">
            <div>
                <div class="flex justify-center lg:justify-between md:space-x-6">
                    <Filter id="filter" class="lg:block absolute lg:relative " :class="{'hidden' : !filterActive}" :cities="cities" :categories="categories"></Filter>
                    <section id="right" class="mx-auto md:w-full" >
                        <Posts :posts ="posts" :savedPost="savedPost" :searchQueryPerformed="searchQueryPerformed"/>

                        <div class="flex justify-center mx-auto text-sm md:text-md md:space-x-2 my-3 md:my-6 bg-white w-60 md:w-fit py-1 md:py-2 px-3 md:px-6 rounded-full ">
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
</template>
