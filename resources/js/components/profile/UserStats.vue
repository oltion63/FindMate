<script setup lang="ts">

const emit = defineEmits(['update:isModalVisible', 'update:isCvVisible']);
const props = defineProps({
    isModalVisible: {
        type: Boolean,
        default: false,
    },
    countApplied:{
        type:Number,
    },
    isCvVisible: {
        type: Boolean,
        default: true,
    },
    countPosts:{
        type:Number,
    },
    countSaved:{
        type:Number,
    },
    countApplications:{
        type:Number,
    },
});

const openModal = () => {
    console.log('Modal open triggered');
    emit('update:isModalVisible', true); // Emit event for parent to handle
};
const openCv = () =>{
    emit('update:isCvVisible', true);
}
</script>

<template>
    <div id="stats" class="space-y-4 lg:space-y-0 lg:flex justify-evenly bg-gray-800 rounded-lg p-6 text-white">
        <button v-if="$page.props.auth.user.role === 'employee'" class="flex space-x-2 text-start items-center" @click="openCv">
            <svg width="40px" height="40px" viewBox="-4.8 -4.8 33.60 33.60" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0">
                    <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill="#9EA3AD"
                          strokewidth="0"></rect>
                </g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M12.6385 3.05526L12.8719 2.08289L12.6385 3.05526ZM13.9373 3.93726L13.2302 4.64437L13.9373 3.93726ZM13.2166 3.29472L13.7391 2.44208L13.2166 3.29472ZM6.09202 20.782L6.54601 19.891L6.09202 20.782ZM5.21799 19.908L6.10899 19.454L5.21799 19.908ZM17.908 20.782L17.454 19.891L17.908 20.782ZM18.782 19.908L17.891 19.454L18.782 19.908ZM18.0627 8.06274L18.7698 7.35563L18.0627 8.06274ZM18.7053 8.78343L19.5579 8.26093L18.7053 8.78343ZM18.9447 9.36154L19.9171 9.12809L18.9447 9.36154ZM5.21799 4.09202L6.10899 4.54601L5.21799 4.09202ZM6.09202 3.21799L6.54601 4.10899L6.09202 3.21799ZM13.9701 11.7575C13.8362 11.2217 13.2933 10.8959 12.7575 11.0299C12.2217 11.1638 11.8959 11.7067 12.0299 12.2425L13.9701 11.7575ZM14.5 18L13.5299 18.2425C13.6411 18.6877 14.0411 19 14.5 19C14.9589 19 15.3589 18.6877 15.4701 18.2425L14.5 18ZM16.9701 12.2425C17.1041 11.7067 16.7783 11.1638 16.2425 11.0299C15.7067 10.8959 15.1638 11.2217 15.0299 11.7575L16.9701 12.2425ZM11 19C11.5523 19 12 18.5523 12 18C12 17.4477 11.5523 17 11 17V19ZM9.23463 17.8478L8.85195 18.7716H8.85195L9.23463 17.8478ZM8.15224 16.7654L7.22836 17.1481H7.22836L8.15224 16.7654ZM11 13C11.5523 13 12 12.5523 12 12C12 11.4477 11.5523 11 11 11V13ZM9.23463 12.1522L8.85195 11.2284L9.23463 12.1522ZM8.15224 13.2346L7.22836 12.8519L8.15224 13.2346ZM14 3.17981C14 2.62752 13.5523 2.17981 13 2.17981C12.4477 2.17981 12 2.62752 12 3.17981H14ZM18.82 10C19.3723 10 19.82 9.55229 19.82 9C19.82 8.44772 19.3723 8 18.82 8V10ZM15.8 20H8.2V22H15.8V20ZM6 17.8V6.2H4V17.8H6ZM8.2 4H11.6745V2H8.2V4ZM18 10.3255V17.8H20V10.3255H18ZM11.6745 4C12.2113 4 12.3167 4.00643 12.405 4.02763L12.8719 2.08289C12.4999 1.99357 12.1161 2 11.6745 2V4ZM14.6444 3.23015C14.3321 2.91791 14.0653 2.64199 13.7391 2.44208L12.6941 4.14736C12.7715 4.19482 12.8506 4.2648 13.2302 4.64437L14.6444 3.23015ZM12.405 4.02763C12.5071 4.05213 12.6046 4.09253 12.6941 4.14736L13.7391 2.44208C13.4707 2.27759 13.178 2.15638 12.8719 2.08289L12.405 4.02763ZM8.2 20C7.62345 20 7.25117 19.9992 6.96784 19.9761C6.69617 19.9539 6.59545 19.9162 6.54601 19.891L5.63803 21.673C6.01641 21.8658 6.40963 21.9371 6.80497 21.9694C7.18864 22.0008 7.65645 22 8.2 22V20ZM4 17.8C4 18.3436 3.99922 18.8114 4.03057 19.195C4.06287 19.5904 4.13419 19.9836 4.32698 20.362L6.10899 19.454C6.0838 19.4045 6.04612 19.3038 6.02393 19.0322C6.00078 18.7488 6 18.3766 6 17.8H4ZM6.54601 19.891C6.35785 19.7951 6.20487 19.6422 6.10899 19.454L4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673L6.54601 19.891ZM15.8 22C16.3436 22 16.8114 22.0008 17.195 21.9694C17.5904 21.9371 17.9836 21.8658 18.362 21.673L17.454 19.891C17.4045 19.9162 17.3038 19.9539 17.0322 19.9761C16.7488 19.9992 16.3766 20 15.8 20V22ZM18 17.8C18 18.3766 17.9992 18.7488 17.9761 19.0322C17.9539 19.3038 17.9162 19.4045 17.891 19.454L19.673 20.362C19.8658 19.9836 19.9371 19.5904 19.9694 19.195C20.0008 18.8114 20 18.3436 20 17.8H18ZM18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362L17.891 19.454C17.7951 19.6422 17.6422 19.7951 17.454 19.891L18.362 21.673ZM17.3556 8.76985C17.7352 9.14941 17.8052 9.22849 17.8526 9.30593L19.5579 8.26093C19.358 7.93471 19.0821 7.66788 18.7698 7.35563L17.3556 8.76985ZM20 10.3255C20 9.8839 20.0064 9.50012 19.9171 9.12809L17.9724 9.59498C17.9936 9.6833 18 9.7887 18 10.3255H20ZM17.8526 9.30593C17.9075 9.3954 17.9479 9.49295 17.9724 9.59498L19.9171 9.12809C19.8436 8.82198 19.7224 8.52935 19.5579 8.26093L17.8526 9.30593ZM6 6.2C6 5.62345 6.00078 5.25117 6.02393 4.96784C6.04612 4.69617 6.0838 4.59545 6.10899 4.54601L4.32698 3.63803C4.13419 4.01641 4.06287 4.40963 4.03057 4.80497C3.99922 5.18864 4 5.65645 4 6.2H6ZM8.2 2C7.65645 2 7.18864 1.99922 6.80497 2.03057C6.40963 2.06287 6.01641 2.13419 5.63803 2.32698L6.54601 4.10899C6.59545 4.0838 6.69617 4.04612 6.96784 4.02393C7.25117 4.00078 7.62345 4 8.2 4V2ZM6.10899 4.54601C6.20487 4.35785 6.35785 4.20487 6.54601 4.10899L5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803L6.10899 4.54601ZM12.0299 12.2425L13.5299 18.2425L15.4701 17.7575L13.9701 11.7575L12.0299 12.2425ZM15.4701 18.2425L16.9701 12.2425L15.0299 11.7575L13.5299 17.7575L15.4701 18.2425ZM11 17C10.5204 17 10.2107 16.9995 9.97376 16.9833C9.74576 16.9677 9.65893 16.9411 9.61732 16.9239L8.85195 18.7716C9.17788 18.9066 9.50779 18.9561 9.83762 18.9787C10.1585 19.0005 10.5477 19 11 19V17ZM7 15C7 15.4523 6.99946 15.8415 7.02135 16.1624C7.04385 16.4922 7.09336 16.8221 7.22836 17.1481L9.07612 16.3827C9.05888 16.3411 9.03227 16.2542 9.01671 16.0262C9.00054 15.7893 9 15.4796 9 15H7ZM9.61732 16.9239C9.37229 16.8224 9.17761 16.6277 9.07612 16.3827L7.22836 17.1481C7.53284 17.8831 8.11687 18.4672 8.85195 18.7716L9.61732 16.9239ZM11 11C10.5477 11 10.1585 10.9995 9.83762 11.0213C9.50779 11.0439 9.17788 11.0934 8.85195 11.2284L9.61732 13.0761C9.65893 13.0589 9.74576 13.0323 9.97376 13.0167C10.2107 13.0005 10.5204 13 11 13V11ZM9 15C9 14.5204 9.00054 14.2107 9.01671 13.9738C9.03227 13.7458 9.05888 13.6589 9.07612 13.6173L7.22836 12.8519C7.09336 13.1779 7.04385 13.5078 7.02135 13.8376C6.99946 14.1585 7 14.5477 7 15H9ZM8.85195 11.2284C8.11686 11.5328 7.53284 12.1169 7.22836 12.8519L9.07612 13.6173C9.17761 13.3723 9.37229 13.1776 9.61732 13.0761L8.85195 11.2284ZM12 3.17981V8H14V3.17981H12ZM14 10H18.82V8H14V10ZM12 8C12 9.10457 12.8954 10 14 10V8V8H12ZM13.2302 4.64437L17.3556 8.76985L18.7698 7.35563L14.6444 3.23015L13.2302 4.64437Z"
                        fill="#ffffff"></path>
                </g>
            </svg>
            <span class="grid items-center">
                                    <span>CV</span>
                                    <span v-if="!$page.props.auth.user.cv" class="font-bold ">No CV Added</span>
                                    <span v-if="$page.props.auth.user.cv" class="font-bold underline">View your CV</span>
                                </span>
        </button>
        <button v-if="$page.props.auth.user.role === 'employer'" class="flex space-x-2 items-center" @click="openModal">
            <svg height="40px" width="40px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-102.4 -102.4 716.80 716.80" xml:space="preserve"
                 fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"><rect x="-102.4" y="-102.4" width="716.80" height="716.80" rx="71.68" fill="#9EA3AD" strokewidth="0"></rect></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">  <g> <path class="st0"
                                                        d="M128.371,334.192c-2.533-2.055-5.094-4.07-7.535-6.254l-0.026,0.054c-0.062-0.054-0.129-0.101-0.191-0.156 L60.074,457.531l-1.738,4.656l2.289,3.633c1.658,2.523,4.344,4.023,7.342,4.023h1.422l57.861-17.996l22.893,54.785 c1.42,3.234,4.5,5.367,8.052,5.367c3.395,0,6.473-1.973,7.893-5.055l46.828-100.289l13.844-29.484 c-0.023-0.004-0.049-0.008-0.072-0.012l0.106-0.226C189.916,371.668,156.213,356.418,128.371,334.192z"></path>
                    <path class="st0"
                          d="M404.978,357.258l-13.598-29.242c-0.018,0.012-0.035,0.027-0.053,0.043l-0.105-0.222 c-27.236,23.996-60.971,40.789-98.039,47.57c-2.611,0.457-5.203,0.996-7.838,1.348l0.028,0.058 c-0.082,0.012-0.162,0.031-0.244,0.043l60.703,130.09c1.422,3.082,4.5,5.055,7.894,5.055c3.553,0,6.631-2.133,8.051-5.367 l22.895-54.785l56.756,17.602l1.342,0.394h1.186c2.998,0,5.682-1.5,7.34-4.023l2.369-4.422L404.978,357.258z"></path>
                    <path class="st0"
                          d="M429.588,173.664C429.588,77.754,351.832,0,255.922,0C160.01,0,82.256,77.754,82.256,173.664 c0,95.992,77.754,173.668,173.666,173.668C351.832,347.332,429.588,269.656,429.588,173.664z M255.922,254.106 c-44.285,0-80.36-36.078-80.36-80.442c0-44.285,36.074-80.359,80.36-80.359c44.363,0,80.438,36.074,80.438,80.359 C336.36,218.027,300.285,254.106,255.922,254.106z"></path> </g> </g></svg>
            <span class="grid text-start items-center">
                                    <span>Company</span>
                                    <span v-if="$page.props.auth.user.company === null" class="font-bold underline">No Company Added</span>
                                    <span v-if="$page.props.auth.user.company !== null" class="font-bold underline">View your company</span>
                                </span>
        </button>
        <span v-if="$page.props.auth.user.role === 'employee'" class="flex space-x-2 items-center">
            <svg width="40px" height="40px" viewBox="-4.8 -4.8 33.60 33.60" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0">
                    <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill="#9EA3AD"
                          strokewidth="0"></rect>
                </g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M19 19.2674V7.84496C19 5.64147 17.4253 3.74489 15.2391 3.31522C13.1006 2.89493 10.8994 2.89493 8.76089 3.31522C6.57467 3.74489 5 5.64147 5 7.84496V19.2674C5 20.6038 6.46752 21.4355 7.63416 20.7604L10.8211 18.9159C11.5492 18.4945 12.4508 18.4945 13.1789 18.9159L16.3658 20.7604C17.5325 21.4355 19 20.6038 19 19.2674Z"
                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg>
            <span class="grid items-center">
                                    <span>Saved Applications</span>
                                    <span class="font-bold">{{ props.countSaved }}</span>
                                </span>
        </span>
        <span v-if="$page.props.auth.user.role === 'employer'" class="flex space-x-2 items-center">
            <svg width="40px" height="40px" viewBox="-4.8 -4.8 33.60 33.60" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0">
                    <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill="#9EA3AD"
                          strokewidth="0"></rect>
                </g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M19 19.2674V7.84496C19 5.64147 17.4253 3.74489 15.2391 3.31522C13.1006 2.89493 10.8994 2.89493 8.76089 3.31522C6.57467 3.74489 5 5.64147 5 7.84496V19.2674C5 20.6038 6.46752 21.4355 7.63416 20.7604L10.8211 18.9159C11.5492 18.4945 12.4508 18.4945 13.1789 18.9159L16.3658 20.7604C17.5325 21.4355 19 20.6038 19 19.2674Z"
                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg>
            <span class="grid items-center">
                                    <span>Applications</span>
                                    <span class="font-bold">{{ props.countApplications }}</span>
                                </span>
        </span>
        <span v-if="$page.props.auth.user.role === 'employee'" class="flex space-x-2 items-center">
            <svg fill="#000000" width="40px" height="40px" viewBox="-4.8 -4.8 33.60 33.60"
                 id="file-done" data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
                 class="icon line-color">
                <g id="SVGRepo_bgCarrier" stroke-width="0">
                    <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill="#9EA3AD"
                          strokewidth="0"></rect>
                </g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <polyline id="secondary" points="14 10.67 11.33 13.33 10 12"
                              style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></polyline>
                    <path id="primary" d="M18,21a1,1,0,0,0,1-1V7L15,3H6A1,1,0,0,0,5,4V20a1,1,0,0,0,1,1Z"
                          style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                </g>
            </svg>
            <span class="grid items-center">
                <span>Applied</span>
                <span class="font-bold">{{props.countApplied}}</span>
            </span>
        </span>
        <span v-if="$page.props.auth.user.role === 'employer'" class="flex space-x-2 items-center">
            <svg fill="#000000" width="40px" height="40px" viewBox="-4.8 -4.8 33.60 33.60"
                 id="file-done" data-name="Line Color" xmlns="http://www.w3.org/2000/svg"
                 class="icon line-color">
                <g id="SVGRepo_bgCarrier" stroke-width="0">
                    <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill="#9EA3AD"
                          strokewidth="0"></rect>
                </g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <polyline id="secondary" points="14 10.67 11.33 13.33 10 12"
                              style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></polyline>
                    <path id="primary" d="M18,21a1,1,0,0,0,1-1V7L15,3H6A1,1,0,0,0,5,4V20a1,1,0,0,0,1,1Z"
                          style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                </g>
            </svg>
            <span class="grid items-center">
                <span>Posts</span>
                <span class="font-bold">{{props.countPosts}}</span>
            </span>
        </span>
    </div>
</template>
