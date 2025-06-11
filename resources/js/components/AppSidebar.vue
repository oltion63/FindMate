<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, User, Briefcase, PlusCircle, Proportions, Wrench, FileCheck } from 'lucide-vue-next';

import AppLogo from './AppLogo.vue';
import { MessageCircle } from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
        icon: LayoutGrid,
        role: ['admin'],
    },
    {
        title: 'Profile',
        href: '/profilePage',
        icon: User,
        role: ['employer', 'employee'],
    },
    {
        title: 'Jobs',
        href: '/jobs',
        icon: Briefcase,
    },
    {
        title: 'Add Job',
        href: '/jobs/create',
        icon: PlusCircle,
        role: ['employer'],
    },
    {
        title: 'Applications',
        href: '/employerApplications',
        icon: FileCheck,
        role: ['employer'],
    },{
        title: 'My Applications',
        href: '/employeeApplications',
        icon: FileCheck,
        role: ['employee'],
    },
    {
        title: 'Chats',
        href: '/chat/rooms',
        icon: MessageCircle,
        role: ['employer', 'employee'],
    },
    {
        title: 'Flagged Posts',
        href: '/admin/reports',
        icon: Proportions,
        role: ['admin'],
    },
    {
        title: 'Manage Users & Posts',
        href: '/admin/manageusers',
        icon: Wrench,
        role: ['admin'],
    },


];

const footerNavItems: NavItem[] = [

];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('profilePage')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems"  />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
