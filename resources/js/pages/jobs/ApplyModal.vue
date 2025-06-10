<script setup>
import * as pdfjsLib from "pdfjs-dist";
import { watch, nextTick } from "vue";
import InputError from "@/components/InputError.vue";
import JobsTextInput from "@/components/jobs/JobsTextInput.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import { User, Mail, Phone, CalendarDays, MapPin, Navigation } from 'lucide-vue-next';

// Set the worker source
pdfjsLib.GlobalWorkerOptions.workerSrc = "/pdf.worker.mjs";
const props = defineProps({
    isApplyModalVisible: {
        type: Boolean,
        default: true
    },
    user: {
        type: Object,
    },
    post: {
        type: Object,
    },
});
const emit = defineEmits();

const closeModal = () => {
    emit('close');
};


const form = useForm({
    user_id: usePage().props.auth.user.id,
    post_id: props.post.id,
})
const submit = () => {
    form.post(route('storeApplication'))
};
const renderPdf = async (fileUrl) => {
    const pdfContainer = document.getElementById("pdfContainer");
    if (!pdfContainer) {
        console.error("PDF container not found!");
        return;
    }
    pdfContainer.innerHTML = ""; // Clear previous content

    try {
        // Load the PDF document
        const pdf = await pdfjsLib.getDocument(fileUrl).promise;

        // Loop through all pages and render them
        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            const page = await pdf.getPage(pageNumber);

            // Create a canvas for each page
            const canvas = document.createElement("canvas");
            canvas.classList.add("mb-4", "border", "rounded");
            pdfContainer.appendChild(canvas);

            const context = canvas.getContext("2d");

            // Set scale for rendering
            const scale = 2;
            const viewport = page.getViewport({ scale: 0.6 });

            // Adjust canvas size to match the PDF page size
            canvas.width = viewport.width;
            canvas.height = viewport.height;

            // Render the page into the canvas
            const renderContext = {
                canvasContext: context,
                viewport,
            };
            await page.render(renderContext).promise;
        }
    } catch (error) {
        console.error("Error rendering PDF:", error);
    }
};


// Watch for `isCvVisible` changes to load the PDF
watch(
    async (newValue) => {
        if (newValue && props.user.cv.file) {
            const fileUrl = `/storage/${props.user.cv.file}`; // Add 'storage/' prefix to the file URL
            await nextTick(); // Wait for the DOM to update
            renderPdf(fileUrl);
        }
    }
);

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-GB");
}
</script>

<template>
    <div v-if="isApplyModalVisible" class="fixed inset-0 bg-black bg-opacity-50 flex overflow-y-auto justify-center items-center z-50 p-4 md:p-6"  @click="closeModal">
        <div class="bg-white p-6 pt-16 rounded-lg shadow-lg max-w-4xl mt-80 lg:mt-0 w-full " @click.stop>
            <form @submit.prevent="submit" class="hidden" id="applicationForm">
                <JobsTextInput
                    id="user_id"
                    type="text"
                    name="user_id"
                    class="mt-1 block w-full"
                    v-model="form.user_id"
                    required
                    autocomplete="user_id"
                />
                <InputError class="mt-2" :message="form.errors.user_id"/>
                <JobsTextInput
                    id="post_id"
                    type="text"
                    name="post_id"
                    class="mt-1 block w-full"
                    v-model="form.post_id"
                    required
                    autocomplete="post_id"
                />
                <InputError class="mt-2" :message="form.errors.post_id"/>
            </form>

            <div class="md:flex justify-evenly md:divide-x divide-gray-800">
                <section class="w-full md:w-1/2 px-2">
                    <header class="py-2 text-xl font-bold mb-4">
                        Your information
                    </header>
                    <div class="py-3 space-y-2 md:space-y-6 border-b border-amber-50">
                        <span class="flex gap-2"><User/> {{ props.user.name }} {{props.user.lastname}}</span>
                        <span class="flex gap-2"><Mail/> {{ props.user.email }}</span>
                        <span class="flex gap-2"><Phone/> {{ props.user.phone }}</span>
                        <span class="flex gap-2"><CalendarDays/> {{ formatDate(props.user.birthday) }}</span>
                        <span class="flex gap-2"><MapPin/> {{ props.user.city.name }}</span>
                        <span class="flex gap-2"><Navigation /> {{ props.user.address ?? 'No Address' }}</span>
                    </div>
                </section>
                <section class="w-full md:w-1/2 px-4">
                    <header class="py-2 text-xl font-bold mb-4">
                        Your CV
                    </header>
                    <section class="h-[55vh] overflow-y-auto">
                        <div id="pdfContainer" class="flex flex-col items-center "></div>
                    </section>
                </section>
            </div>
            <footer class="flex justify-end space-x-4 mt-8">
                <button type="button" @click="closeModal" class="text-white bg-gradient-to-br from-red-600 to-red-400 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Cancel
                </button>
                <button type="submit" form="applicationForm" class="text-white bg-gradient-to-br from-blue-900 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Apply Now
                </button>
            </footer>
        </div>
    </div>

</template>
