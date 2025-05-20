<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import Filter from "@/components/jobs/Filter.vue";
import Posts from "@/components/jobs/Posts.vue";
import {computed, ref} from "vue";

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

</script>

<template>
    <Head title="Jobs"/>

    <AppLayout>
        <template #header>
            <div class="pt-16 space-y-4 lg:space-y-0 lg:flex lg:space-x-4 justify-between items-center">
                <div
                    class="text-2xl font-bold leading-tight text-gray-800  w-full flex justify-between"
                >
                    Jobs
                    <div class="flex space-x-2">
                        <button class="block lg:hidden p-1.5 md:p-3 h-8 md:h-10 bg-gray-50 rounded-lg hover:bg-blue-600" @click="toggleFilter" type="button">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V17L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                        <select v-model="sortBy" @change="searchPosts" class="border w-fit md:w-36 border-gray-300 md:pl-4 text-xs md:text-sm rounded-lg md:p-1.5 h-8 md:h-10">
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
                <div class="w-full lg:w-1/3 flex justify-end items-center space-x-4">
                    <form class="flex w-full justify-start md:justify-end" @submit.prevent="searchPosts">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
                        <div class="relative w-full flex ">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class=" w-3 md:w-4 h-3 md:h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input
                                type="search"
                                id="default-search"
                                v-model="searchQuery"
                                class="block w-full md:p-1.5 ps-7 md:ps-10 text-xs md:text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 h-8 md:h-10"
                                placeholder="Search Location, Position..."
                            />
                            <button type="submit" class=" text-white absolute end-1 bottom-0.5 md:bottom-1 xl:bottom-1 bg-blue-600 hover:bg-blue-800 font-medium rounded-lg text-xs md:text-sm px-3 py-1.5">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

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
