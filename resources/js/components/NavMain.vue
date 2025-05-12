<script setup lang="ts">
import { computed } from 'vue'; // Add this import
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();
const userRole = page.props.auth.user.role;


const visibleItems = computed(() => {
    return props.items.filter((item) => !item.role || item.role.includes(userRole));
});
</script>


<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in visibleItems" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="item.href === page.url"
                    :tooltip="item.title"
                >
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>

