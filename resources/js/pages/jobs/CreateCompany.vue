<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import JobsTextInput from "@/components/jobs/JobsTextInput.vue";
import TextArea from "@/components/jobs/TextArea.vue";
import {ref} from "vue";
import InputLabel from "@/components/InputLabel.vue";
import InputError from "@/components/InputError.vue";
import ImgInput from "@/components/ImgInput.vue";

const input = ref('');

const props = defineProps({
    authUser: {
        type: Number,
        required: true,
    },
});
const form = useForm({
    user_id: props.authUser,
    name: '',
    image: '',
    description: '',
    address: '',
    phone: '',
    website: '',
    email: '',
});
console.log(form)
const submit = () => {
    console.log(form)
    form.post(route('storeCompany'))
};

const imageSrc = ref('');
const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        imageSrc.value = '';
    }
};

</script>

<template>
    <Head title="Add Jobs"/>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="py-4 px-8 mx-auto max-w-2xl lg:py-8 bg-white border-gray-200 border rounded-lg mt-4 ">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Add your company</h2>
                <form @submit.prevent="submit">
                    <input type="hidden" name="user_id" v-model="form.user_id">
                    <div class="flex justify-between mt-4 h-full items-center">
                        <div class="w-1/2 h-full space-y-12">
                            <div>
                                <InputLabel for="image" class="mb-4" value="Image"/>

                                <ImgInput
                                    id="image"
                                    accept="image/*"
                                    class="hidden"
                                    name="image"
                                    v-model="form.image"
                                    @change="previewImage"
                                    autocomplete="image"
                                />
                                <InputError class="mt-2" :message="form.errors.image"/>
                            </div>
                            <div>
                                <label for="image"
                                       class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-2 py-2.5 hover:cursor-pointer dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Choose Image
                                </label>
                            </div>

                        </div>

                        <div class="w-1/2">
                            <div v-if="imageSrc" class="items-center flex justify-center">
                                <img :src="imageSrc" alt="Image Preview"
                                     class="w-28 h-28 object-cover rounded-full border-2 border-indigo-500"/>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 mt-6">
                        <div class="sm:col-span-2">
                            <InputLabel for="name" class="mb-2" value="Name"/>
                            <JobsTextInput
                                placeholder="Company Name"
                                id="name"
                                type="text"
                                name="name"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                        <div class="sm:col-span-2">
                            <InputLabel for="description" class="mb-2" value="Description"/>
                            <TextArea
                                placeholder="Job description here"
                                v-model="form.description"
                                id="description"
                                name="description"
                                required
                                autocomplete="description"
                            />
                            <InputError class="mt-2" :message="form.errors.description"/>
                        </div>
                        <div>
                            <InputLabel for="address" class="mb-2" value="Address"/>
                            <JobsTextInput
                                placeholder="Company Name"
                                id="address"
                                type="text"
                                name="address"
                                class="mt-1 block w-full"
                                v-model="form.address"
                                required
                                autocomplete="address"
                            />
                            <InputError class="mt-2" :message="form.errors.address"/>
                        </div>
                        <div>
                            <InputLabel for="phone" class="mb-2" value="Phone"/>
                            <JobsTextInput
                                placeholder="+383-xxx-xxx"
                                id="phone"
                                type="text"
                                name="phone"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                required
                                autocomplete="phone"
                            />
                            <InputError class="mt-2" :message="form.errors.phone"/>
                        </div>
                        <div>
                            <InputLabel for="website" class="mb-2" value="Website"/>
                            <JobsTextInput
                                placeholder="yourcompany.com"
                                id="website"
                                type="text"
                                name="website"
                                class="mt-1 block w-full"
                                v-model="form.website"
                                required
                                autocomplete="website"
                            />
                            <InputError class="mt-2" :message="form.errors.website"/>
                        </div>
                        <div>
                            <InputLabel for="email" class="mb-2" value="Email"/>
                            <JobsTextInput
                                placeholder="youcompany@example.com"
                                id="email"
                                type="text"
                                name="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="email"
                            />
                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-teal-500 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                        Add Company
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
