<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import NavLink from "@/components/NavLink.vue";
import HomeLogo from "@/components/HomeLogo.vue";


</script>
<template>
    <nav
        class=" fixed top-0 left-0 w-full bg-opacity-50 backdrop-blur-lg bg-gray-500 z-50"
    >
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex shrink-0 items-center">
                        <Link :href="route('welcome')">
                            <HomeLogo
                                class="block h-20 w-20  text-gray-800"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                    >
                        <NavLink
                            v-if="route().current('home') || route().current('') || route().current('/') "
                            :href="route('home')"
                            :active="route().current('home')"
                        >
                            Home
                        </NavLink>
                        <NavLink
                            :href="route('jobs.index')"
                            :active="route().current('jobs.index')"
                        >
                            Jobs
                        </NavLink>
                        <NavLink
                            :href="'#footer'"
                        >
                            About
                        </NavLink>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="space-x-2 items-center">
                        <Link
                            :href="route('login')"
                            class="rounded-md px-1.5 py-1 text-sm md:px-3 md:py-2 text-black border-2 border-gray-700 items-center "
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="rounded-md px-1.5 py-1 text-sm md:px-3 md:py-2 text-black border-2 border-gray-700 items-center "
                        >
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
