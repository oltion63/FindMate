<script setup>
import {nextTick, watch} from "vue";
import * as pdfjsLib from "pdfjs-dist";

// Set PDF.js worker source
pdfjsLib.GlobalWorkerOptions.workerSrc = "/pdf.worker.mjs";

// Props
const props = defineProps({
    isEmCvVisible: {
        type: Boolean,
        default:true,
    },
    selectedCv: {
        type: String,
        default: null,
    },
});
console.log('cv: ', props.selectedCv)
// Emits
const emit = defineEmits(["close"]);

// Methods
const closeModal = () => {
    emit("close");
};

const renderPdf = async (fileUrl) => {
    const pdfContainer = document.getElementById("pdfContainer");
    if (!pdfContainer) {
        console.error("No URL provided for PDF rendering.");
        return;
    }

    console.log("Rendering PDF from:", fileUrl);

    try {
        // Load the PDF document
        const pdf = await pdfjsLib.getDocument(fileUrl).promise;

        // Get the first page
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
watch(
    async (cvUrl) => {
        if (cvUrl && props.selectedCv) {
            const fileUrl = `storage/${props.selectedCv}`;
            await nextTick();
            await renderPdf(fileUrl);
        }
    }
);
</script>


<template>
    <div
        v-if="isEmCvVisible"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4"
        @click="closeModal"
    >
        <div
            class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full h-[90vh] overflow-y-auto"
            @click.stop
        >
            <div class="flex justify-between">
                <h2 class="text-xl font-bold mb-4">CV</h2>
                <button
                    @click="closeModal"
                    class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >Close
                </button>
            </div>
            <div id="pdfContainer" class="flex flex-col items-center"></div>
        </div>
    </div>
</template>
