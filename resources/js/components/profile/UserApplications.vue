<script setup lang="ts">

</script>

<template>
    <div id="table1" >
        <div class="mx-auto max-w-screen-xl ">
            <div class="bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden rounded-lg">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <span class="font-bold text-white text-xl">Applications</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-gray-400 capitalize">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Applicant</th>
                            <th scope="col" class="px-4 py-3">Application Date</th>
                            <th scope="col" class="px-4 py-3">Applicant CV</th>
                            <th scope="col" class="px-4 py-3">Accept</th>
                            <th scope="col" class="px-4 py-3">Reject</th>
                        </tr>
                        </thead>
                        <tbody class="max-h-96 overflow-y-auto">

                        <tr class="border-b border-gray-700">
                            <th scope="row" class="px-4 py-3 font-medium text-white max-w-60 break-words whitespace-normal">
                                Manager</th>
                            <td class="px-4 py-3">Oltion</td>
                            <td class="px-4 py-3">26.04.2025</td>
                            <td class="px-4 py-3">
                                <button
                                    class="text-blue-500 underline"
                                >
                                    View CV
                                </button></td>
                            <td class="px-4 py-3">
                                <button
                                    class="text-emerald-600 underline"
                                >
                                    Accept
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <button
                                    class="text-red-600 underline"
                                >
                                    Reject
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>
