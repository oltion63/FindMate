<script setup lang="ts">

</script>

<template>
    <footer class="pt-14 pb-8 bg-[#111111]/90 backdrop-blur-md text-[#F6F6F6]">
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-sm mt-14 text-center md:text-left">

            <!-- Logo Section -->
            <div class="-mt-8 flex items-start justify-center md:col-span-1">
                <img :src="'storage/images/logo.png'" class=" invert md:w-[180px] md:h-[180px] w-[130px] h-[130px]" alt="Logo" />
            </div>

            <!-- Contact Section -->
            <div>
                <h4 class="uppercase font-bold text-sm mb-4 tracking-wide text-[#FFCB74]">CONTACT</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                             Email
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                            Phone number
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                             City
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Social Media Section -->
            <div>
                <h4 class="uppercase font-bold text-sm mb-4 tracking-wide text-[#FFCB74]">SOCIAL MEDIA</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="https://www.facebook.com" target="_blank" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                            Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com" target="_blank" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                           Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com" target="_blank" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                            LinkedIn
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Learn More Section -->
            <div class="w-fit">
                <h4 class="uppercase font-bold text-sm mb-4 tracking-wide text-[#FFCB74]">LEARN MORE</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                            Community
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link block transition-transform duration-200 transform hover:scale-105 hover:text-[#FFCB74]">
                            Terms Of Use
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="container mx-auto flex justify-center items-center w-full mt-10 border-t border-[#2F2F2F] pt-6 text-xs text-center text-white">
            <p>© FindMate. All Rights Reserved.</p>
        </div>
    </footer>
</template>

