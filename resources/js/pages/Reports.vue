<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types/index.js';

const props = defineProps({
    reports: Array,
});

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB');
}

const form = useForm({
    status: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Flagged Posts',
        href: '/reports',
    },
];
</script>

<template>
    <Head title="Flagged Posts" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div id="table1">
            <div class="mx-auto mt-9 max-w-[90%]">
                <div class="relative w-full overflow-x-auto scroll-smooth rounded-lg bg-[#F6F6F6] shadow-md sm:rounded-lg">
                    <div class="flex justify-center p-4">
                        <span class="text-base font-semibold text-[#111111]">Flagged Posts</span>
                    </div>
                    <div class="max-h-60 overflow-x-auto scroll-smooth">
                        <table class="w-full text-left text-sm capitalize text-[#2F2F2F]">
                            <thead class="sticky top-0 z-10 bg-[#2F2F2F] text-xs uppercase text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Post</th>
                                    <th scope="col" class="px-4 py-3">Reported By</th>
                                    <th scope="col" class="px-4 py-3">Description</th>
                                    <th scope="col" class="px-4 py-3">Report Date</th>
                                    <th scope="col" class="px-4 py-3">Report Status</th>
                                    <th scope="col" class="text-center" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="reports.length === 0">
                                    <td colspan="7" class="px-4 py-3 text-center text-[#2F2F2F]">No reports yet</td>
                                </tr>
                                <tr v-for="report in reports" :key="report.id" class="border-b border-[#D4D4D4]">
                                    <th scope="row" class="max-w-60 whitespace-normal break-words px-4 py-3 font-medium text-[#111111]">
                                        <Link
                                            :href="route('jobs.show', { id: report.post.id })"
                                        >
                                        {{ report.post.tittle }}
                                        </Link>
                                    </th>
                                    <td class="px-4 py-3">{{ report.user.name }}</td>
                                    <td class="px-4 py-3 max-w-60 max-h-10">
                                        <div class="overflow-y-auto max-h-14">{{ report.description }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ formatDate(report.created_at) }}</td>
                                    <td class="px-4 py-3">{{ report.status }}</td>
                                    <td class="px-4 py-3 flex space-x-4" colspan="2">
                                        <form
                                            :id="'report-' + report.id"
                                            @submit.prevent="form.post(route('reviewedReport', { id: report.id }))"
                                        ></form>
                                        <button
                                            v-if="report.status === 'pending'"
                                            type="submit"
                                            :form="'report-' + report.id"
                                            class="text-[#2F2F2F] underline"
                                        >
                                            Take action
                                        </button>

                                        <form
                                            :id="'report+' + report.id"
                                            @submit.prevent="form.post(route('dismissedReport', { id: report.id }))"
                                        ></form>
                                        <button
                                            v-if="report.status === 'pending'"
                                            type="submit"
                                            :form="'report+' + report.id"
                                            class="text-[#2F2F2F] underline"
                                        >
                                            Dismiss
                                        </button>

                                        <span v-if="report.status !== 'pending'">Action Completed</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
