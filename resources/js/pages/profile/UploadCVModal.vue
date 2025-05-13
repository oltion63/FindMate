<script setup>
import { ref, nextTick } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import * as pdfjsLib from "pdfjs-dist";

pdfjsLib.GlobalWorkerOptions.workerSrc = '/pdf.worker.mjs';

defineProps({
    showModal: {
        type: Boolean,
        default: true,
    }
});
const emit = defineEmits(["close"]);

const pdfLoaded = ref(false);
const file = ref(null);
const pdfViewerContainer = ref(null);
const form = useForm({
    user_id: usePage().props.auth.user.id,
    file: null,
});

const handleFileUpload = async (event) => {
    const uploadedFile = event.target.files[0];

    if (uploadedFile && uploadedFile.type === "application/pdf") {
        await nextTick(() => {
            if (pdfViewerContainer.value) {
                pdfViewerContainer.value.innerHTML = "";
            }
        });

        file.value = uploadedFile;
        form.file = uploadedFile;

        event.target.value = null;

        const fileUrl = URL.createObjectURL(uploadedFile);
        await renderPDF(fileUrl);
        pdfLoaded.value = true;
    } else {
        alert("Please upload a valid PDF file.");
    }
};

const renderPDF = async (url) => {
    const pdf = await pdfjsLib.getDocument(url).promise;
    await nextTick(() => {
        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            renderPage(pdf, pageNumber);
        }
    });
};

const renderPage = async (pdf, pageNumber) => {
    const page = await pdf.getPage(pageNumber);
    const viewport = page.getViewport({ scale: 1.0 });

    // Create a new canvas element for each page
    const canvas = document.createElement("canvas");
    pdfViewerContainer.value.appendChild(canvas);

    const context = canvas.getContext("2d");
    canvas.width = viewport.width;
    canvas.height = viewport.height;

    const renderContext = {
        canvasContext: context,
        viewport: viewport,
    };

    await page.render(renderContext).promise.then(() => {
        console.log(`Page ${pageNumber} rendered`);
    }).catch((error) => {
        console.error(`Error rendering page ${pageNumber}:`, error);
    });
};

const submitCV = () => {
    if (!file.value) {
        alert("No file uploaded!");
        return;
    }
    form.file = file.value;

    form.post("storeCV", {
        onSuccess: () => {
            closeModal();
        },
        onError: () => {
            alert("An error occurred. Please try again.");
        },
    });
};

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4"
         @click="closeModal">
        <div class="bg-white p-3 rounded-lg shadow-lg max-w-4xl w-full h-full overflow-y-auto" @click.stop>
            <h2 class="text-xl font-semibold mb-4">Upload Your CV</h2>
            <input type="number" class="hidden" name="user_id" id="user_id" :value="form.user_id">
            <input
                id="file"
                type="file"
                accept="application/pdf"
                @change="handleFileUpload"
                class="hidden"
            />
            <label for="file"
                   class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center">Choose
                File</label>

            <div v-if="pdfLoaded" class="mt-4">
                <h3 class="text-lg font-medium mb-2">Preview:</h3>
                <div ref="pdfViewerContainer" class="overflow-y-auto max-h-96 border border-gray-500 rounded-lg">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button
                    @click="submitCV"
                    :disabled="form.processing"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 disabled:opacity-50"
                >
                    {{ form.processing ? "Submitting..." : "Submit" }}
                </button>
                <button
                    @click="closeModal"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>
