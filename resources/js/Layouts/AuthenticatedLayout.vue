<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Navigation -->
        <nav class="relative z-10 bg-white/80 backdrop-blur-sm border-b border-gray-200/50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <!-- Logo and Navigation Links -->
                    <div class="flex items-center space-x-8">
                        <!-- Logo -->
                        <Link :href="route('dashboard')" class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                DearFuture
                            </span>
                        </Link>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex space-x-6">
                            <NavLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                                class="px-3 py-2 text-gray-700 hover:text-indigo-600 font-medium transition-colors"
                            >
                                Dashboard
                            </NavLink>
                            <NavLink
                                :href="route('capsules.index')"
                                :active="route().current('capsules.*')"
                                class="px-3 py-2 text-gray-700 hover:text-indigo-600 font-medium transition-colors"
                            >
                                My Capsules
                            </NavLink>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium transition-colors rounded-lg hover:bg-gray-50">
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-white">
                                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                            </span>
                                        </div>
                                        <span class="hidden sm:block">{{ $page.props.auth.user.name }}</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <DropdownLink
                                        :href="route('profile.edit')"
                                        class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Profile</span>
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:text-red-600 hover:bg-red-50 w-full text-left"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Log Out</span>
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header
            class="bg-white/60 backdrop-blur-sm border-b border-gray-200/50"
            v-if="$slots.header"
        >
            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            <slot />
        </main>
    </div>
</template>
