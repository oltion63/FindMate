<template>
    <div class="p-6 flex flex-col items-center justify-center text-center">
        <h1 class="text-2xl font-bold mb-4 text-[#111111]">Generate Reports</h1>

        <div class="flex flex-wrap gap-4 items-center justify-center mb-6">
            <select v-model="type" class="border border-[#E0E0E0] p-2 rounded bg-white text-[#2F2F2F]">
                <option value="users">User Registrations</option>
                <option value="jobs">Jobs Posted</option>
                <option value="applications">Job Applications</option>
                <option value="applications_per_job">Applications per Job</option>
                <option value="accepted_applications">Accepted Applications</option>
            </select>

            <select v-model="interval" class="border border-[#E0E0E0] p-2 rounded bg-white text-[#2F2F2F]">
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>

            <button @click="handleGenerate" class="bg-[#FFCB74] text-[#111111] px-4 py-2 rounded hover:bg-[#F6F6F6] hover:underline transition">
                Generate Report
            </button>
        </div>

        <div v-if="message" class="text-green-600 font-semibold mt-4">{{ message }}</div>

        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg shadow-lg p-6 w-80">
                <h2 class="text-lg font-semibold mb-4 text-[#111111]">Choose Export Format</h2>
                <div class="flex justify-between gap-4">
                    <button
                        @click="exportReport('pdf')"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                    >
                        Export as PDF
                    </button>
                    <button
                        @click="exportReport('excel')"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                    >
                        Export as Excel
                    </button>
                </div>
                <button
                    @click="showModal = false"
                    class="mt-4 text-sm text-gray-500 hover:text-gray-700"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref } from 'vue'
import axios from 'axios'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import * as XLSX from 'xlsx'
import { saveAs } from 'file-saver'

const type = ref('users')
const interval = ref('weekly')
const report = ref([])
const message = ref('')
const showModal = ref(false)

const fetchReport = async () => {
    try {
        const response = await axios.get('/dashboard/reports/data', {
            params: { type: type.value, interval: interval.value },
        });

        if (Array.isArray(response.data)) {
            report.value = response.data;
        } else if (typeof response.data === 'object') {
            report.value = Object.values(response.data).flat();
        } else {
            report.value = [];
        }
    } catch (error) {
        console.error('Error fetching report:', error);
        report.value = [];
    }
};

const exportPDF = () => {
    if (!report.value.length) {
        message.value = 'No data to export.'
        return
    }

    const doc = new jsPDF()
    doc.text(`${type.value.toUpperCase()} Report (${interval.value})`, 14, 16)

    const columns = Object.keys(report.value[0]).map((key) => ({
        header: key.replace(/_/g, ' ').toUpperCase(),
        dataKey: key,
    }))

    autoTable(doc, {
        startY: 20,
        head: [columns.map((col) => col.header)],
        body: report.value.map((row) => columns.map((col) => row[col.dataKey])),
    })

    doc.save(`${type.value}_${interval.value}_report.pdf`)
    message.value = 'Report downloaded as PDF.'
}

const exportExcel = () => {
    if (!report.value.length) {
        message.value = 'No data to export.'
        return
    }

    const firstRow = report.value[0]
    const isAggregated = 'period' in firstRow && 'count' in firstRow

    let wsData = []

    if (isAggregated) {
        wsData = [['Period', 'Count'], ...report.value.map((r) => [r.period, r.count])]
    } else {
        const headers = Object.keys(firstRow)
        wsData.push(headers.map((h) => h.replace(/_/g, ' ').toUpperCase()))
        report.value.forEach((row) => {
            wsData.push(headers.map((h) => row[h]))
        })
    }

    const ws = XLSX.utils.aoa_to_sheet(wsData)
    const wb = XLSX.utils.book_new()
    XLSX.utils.book_append_sheet(wb, ws, 'Report')
    const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' })
    const blob = new Blob([wbout], { type: 'application/octet-stream' })
    saveAs(blob, `${type.value}_${interval.value}_report.xlsx`)
    message.value = 'Report downloaded as Excel.'
}

const handleGenerate = async () => {
    message.value = ''
    await fetchReport()

    if (!report.value.length) {
        message.value = 'No data found for selected criteria.'
        return
    }

    showModal.value = true
}

const exportReport = (format) => {
    showModal.value = false

    if (format === 'pdf') {
        exportPDF()
    } else if (format === 'excel') {
        exportExcel()
    }
}
</script>
