<script setup lang="ts">
import {Link} from "@inertiajs/vue3";

</script>

<template>
    <div id="table1" class="mb-6" >
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden rounded-lg">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <span class="font-bold text-white text-xl">Your Posts</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Type</th>
                            <th scope="col" class="px-4 py-3">Expires At</th>
                            <th scope="col" class="px-4 py-3">Available Slots</th>
                            <th scope="col" class="px-4 py-3">Salary</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                        </thead>
                        <tbody class="overflow-y-auto max-h-96">
                        <tr class="border-b border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-white max-w-60 break-words whitespace-normal">
                                Menager
                            </th>
                            <td class="px-4 py-3">Remote</td>
                            <td class="px-4 py-3">20.10.2025</td>
                            <td class="px-4 py-3">6</td>
                            <td class="px-4 py-3">1500$</td>
                            <td class="px-4 py-3">
                                <Link
                                    class="underline text-blue-500 "
                                >
                                    See More
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
