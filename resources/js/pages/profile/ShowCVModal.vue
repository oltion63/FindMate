<script setup>
import * as pdfjsLib from "pdfjs-dist";
import {watch, nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import ConfirmationModal from "@/components/ConfirmationModal.vue";

// Set the worker source
pdfjsLib.GlobalWorkerOptions.workerSrc = "/pdf.worker.mjs";

// Define props
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    isCvVisible: {
        type: Boolean,
        default: true,
    },
});

const form = useForm({
    id: props.user.cv.id
})

const emit = defineEmits();

const closeCv = () => {
    emit("close");
};

// Function to render all pages of the PDF
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
            canvas.classList.add("mb-4", "w-full", "border", "rounded");
            pdfContainer.appendChild(canvas);

            const context = canvas.getContext("2d");

            // Set scale for rendering
            const scale = 2;
            const viewport = page.getViewport({ scale: 1.0 });

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
            const fileUrl = `storage/${props.user.cv.file}`; // Add 'storage/' prefix to the file URL
            await nextTick(); // Wait for the DOM to update
            renderPdf(fileUrl);
        }
    }
);
const showDeleteModal = ref(false);

const confirmDelete = () => {
    form.delete(route('deleteCV', { id: props.user.cv.id }));
    showDeleteModal.value = false;
    closeCv();
};
</script>

<template>
    <div
        v-if="isCvVisible"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4"
        @click="closeCv"
    >
        <div
            class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full h-[90vh] overflow-y-auto"
            @click.stop
        >
            <div class="flex justify-between mb-8">
                <h2 class="text-lg lg:text-xl font-bold mb-4">Your CV</h2>
                <div class="flex w-1/2 justify-end space-x-4">
                    <button
                        @click="closeCv"
                        class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-3 lg:px-5 lg:py-2.5 text-center"
                    >Close
                    </button>
                    <button
                        type="button"
                        @click="showDeleteModal = true"
                        class="text-white bg-gradient-to-br from-gray-600 to-red-600 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-3 lg:px-5 lg:py-2.5 text-center"
                    >Delete
                    </button>
                </div>
            </div>
            <div id="pdfContainer" class="flex flex-col items-center"></div>
            <form id="deleteForm" class="hidden" @submit.prevent="form.delete(route('deleteCV', {id: props.user.cv.id} ))">

            </form>
        </div>
    </div>
    <ConfirmationModal
        :show="showDeleteModal"
        title="Confirm Deletion"
        message="Are you sure you want to delete your CV?"
        @close="showDeleteModal = false"
        @confirm="confirmDelete"
    />
</template>
