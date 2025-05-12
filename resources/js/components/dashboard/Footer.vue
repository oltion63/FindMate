<script setup lang="ts">

</script>

<template>
    <footer class="pt-14 pb-4 bg-opacity-50 backdrop-blur-lg bg-gray-500">
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-sm mt-14 text-center md:text-left">

            <!-- Logo Section -->
            <div class="-mt-8 flex items-start justify-center md:col-span-1">
                <img  :src="'storage/images/logo.png'" class="md:w-[180px] md:h-[180px] w-[130px] h-[130px]">
            </div>

            <div>
                <h4 class="uppercase font-bold text-xs sm:text-sm mb-3 tracking-wide text-gray-100">CONTACT</h4>
                <ul class="space-y-2 mb-16 sm:text-center md:text-left">
                    <li>
                        <a href="#" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Email
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Phone number
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> City
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Social Media Section -->
            <div>
                <h4 class="uppercase font-bold text-xs sm:text-sm mb-3 tracking-wide text-gray-100">SOCIAL MEDIA</h4>
                <ul class="space-y-2 mb-16 sm:text-center md:text-left">
                    <li>
                        <a href="https://www.facebook.com" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> LinkedIn
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Learn More Section -->
            <div>
                <h4 class="uppercase font-bold text-xs sm:text-sm mb-3 tracking-wide text-gray-100">LEARN MORE</h4>
                <ul class="space-y-2 mb-16 sm:text-center md:text-left">
                    <li>
                        <a href="#" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Community
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#" class="footer-link mb-2 text-center sm:text-left transition-transform duration-200 transform hover:scale-110 hover:translate-x-2 hover:text-white">
                            <span class="arrow">></span> Terms Of Use
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="container mx-auto flex justify-center items-center w-full mb-3 text-xs border-t border-white-500 pt-8 footer-bottom">
            <div class="text-center w-full">
                <p>Copyright FindJob. . All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</template>
