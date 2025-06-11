<script setup>
import Checkbox from '@/components/Checkbox.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { login as passportLogin } from '@/lib/passportAuth';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const loginError = ref('');

const submit = () => {
    loginError.value = '';
    form.post(route('login'), {
        onSuccess: async (page) => {
            const result = await passportLogin(form.email, form.password);
            if (result.success) {
            } else {
                loginError.value = 'Logged in, but failed to get API token.';
            }
        },
        onError: () => {
            form.reset('password');
        },
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase>
        <Head title="Log in" />

        <div v-if="loginError" class="mb-4 text-sm font-medium text-red-600">
            {{ loginError }}
        </div>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <div class="z-30 mt-6 w-full overflow-hidden bg-gradient-to-b from-[#FFCB74] via-white to-gray-300 y-100 px-6 pb-4 shadow-lg sm:max-w-sm sm:rounded-lg ">
            <img src="/storage/images/logo.png" width="150px" height="150px" class="invert-0 mx-auto" alt="logo">
            <span class="text-xl font-bold flex justify-center mb-2">Welcome Back</span>
            <p class="text-center text-gray-600 mb-6">Log in to continue your journey with us.</p>
        <form @submit.prevent="submit" class="">
            <div>
                <span class="absolute flex mt-1.5 ml-2 bg-transparent ">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="24" height="24" fill="none"></rect> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.96802 4H18.032C18.4706 3.99999 18.8491 3.99998 19.1624 4.02135C19.4922 4.04386 19.8221 4.09336 20.1481 4.22836C20.8831 4.53284 21.4672 5.11687 21.7716 5.85195C21.9066 6.17788 21.9561 6.50779 21.9787 6.83762C22 7.15088 22 7.52936 22 7.96801V16.032C22 16.4706 22 16.8491 21.9787 17.1624C21.9561 17.4922 21.9066 17.8221 21.7716 18.1481C21.4672 18.8831 20.8831 19.4672 20.1481 19.7716C19.8221 19.9066 19.4922 19.9561 19.1624 19.9787C18.8491 20 18.4706 20 18.032 20H5.96801C5.52936 20 5.15088 20 4.83762 19.9787C4.50779 19.9561 4.17788 19.9066 3.85195 19.7716C3.11687 19.4672 2.53284 18.8831 2.22836 18.1481C2.09336 17.8221 2.04386 17.4922 2.02135 17.1624C1.99998 16.8491 1.99999 16.4706 2 16.032V7.96802C1.99999 7.52937 1.99998 7.15088 2.02135 6.83762C2.04386 6.50779 2.09336 6.17788 2.22836 5.85195C2.53284 5.11687 3.11687 4.53284 3.85195 4.22836C4.17788 4.09336 4.50779 4.04386 4.83762 4.02135C5.15088 3.99998 5.52937 3.99999 5.96802 4ZM4.31745 6.27777C4.68114 5.86214 5.3129 5.82002 5.72854 6.1837L11.3415 11.095C11.7185 11.4249 12.2815 11.4249 12.6585 11.095L18.2715 6.1837C18.6871 5.82002 19.3189 5.86214 19.6825 6.27777C20.0462 6.69341 20.0041 7.32517 19.5885 7.68885L13.9755 12.6002C12.8444 13.5899 11.1556 13.5899 10.0245 12.6002L4.41153 7.68885C3.99589 7.32517 3.95377 6.69341 4.31745 6.27777Z" fill="#454545"></path> </g></svg>
                </span>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full pl-8"
                    v-model="form.email"
                    placeholder="Email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <span class="absolute mt-1.5 ml-2 flex">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5V16.5M7 10.0288C7.47142 10 8.05259 10 8.8 10H15.2C15.9474 10 16.5286 10 17 10.0288M7 10.0288C6.41168 10.0647 5.99429 10.1455 5.63803 10.327C5.07354 10.6146 4.6146 11.0735 4.32698 11.638C4 12.2798 4 13.1198 4 14.8V16.2C4 17.8802 4 18.7202 4.32698 19.362C4.6146 19.9265 5.07354 20.3854 5.63803 20.673C6.27976 21 7.11984 21 8.8 21H15.2C16.8802 21 17.7202 21 18.362 20.673C18.9265 20.3854 19.3854 19.9265 19.673 19.362C20 18.7202 20 17.8802 20 16.2V14.8C20 13.1198 20 12.2798 19.673 11.638C19.3854 11.0735 18.9265 10.6146 18.362 10.327C18.0057 10.1455 17.5883 10.0647 17 10.0288M7 10.0288V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10.0288" stroke="#3f3f3f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </span>
                <TextInput
                    id="password"
                    type="password"
                    placeholder="Password"
                    class="mt-1 block w-full pl-8"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-2 flex justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                    >
                </label>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link>
            </div>

            <div class="mt-4 flex items-center ">
                <PrimaryButton
                    class="w-full bg-[#111111] hover:bg-gray-700 border border-gray-200 py-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    <span class="mx-auto ">Log In</span>
                </PrimaryButton>
            </div>
            <div v-if="loginError" class="mt-4 text-sm text-red-600">
                {{ loginError }}
            </div>
            <div class="w-full flex items-center text-sm text-center text-gray-600 my-4">
                <hr class="flex-grow border-t border-gray-300">
                <span class="px-2">Or sign in with</span>
                <hr class="flex-grow border-t border-gray-300">
            </div>
            <div class="mt-4 flex items-center ">
                <a
                    :href="route('auth.google')"
                    class="w-full bg-white hover:bg-gray-100 shadow-md border border-gray-200 py-2.5 flex justify-center rounded-md"
                >
                    <span class="mx-auto text-emerald-600">
                        <xml version="1.0" >
                        <svg height="20px"  viewBox="0 0 272 92" width="272" xmlns="http://www.w3.org/2000/svg"><path d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" fill="#EA4335"/><path d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" fill="#FBBC05"/><path d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 7.87 11.17 7.87 7.31 0 11.84-4.51 11.84-13v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.61h9.25zm-8.56 20.92c0-7.81-5.21-13.52-11.84-13.52-6.72 0-12.35 5.71-12.35 13.52 0 7.73 5.63 13.36 12.35 13.36 6.63 0 11.84-5.63 11.84-13.36z" fill="#4285F4"/><path d="M225 3v65h-9.5V3h9.5z" fill="#34A853"/><path d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-23.27-7.98l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" fill="#EA4335"/><path d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.66-2.66 4.41-6.46 5.1-11.65l-22.49.01z" fill="#4285F4"/></svg>
                        </xml>
                    </span>

                </a>
            </div>
            <div class="flex justify-center mt-4">
                <Link
                    :href="route('register')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                Don’t have an account? Sign up
                </Link>
            </div>
        </form>
        </div>
    </AuthBase>
</template>
