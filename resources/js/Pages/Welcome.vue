<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="DearFuture - Time Capsules for Tomorrow" />
    
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Navigation -->
        <nav class="relative z-10 px-4 sm:px-6 py-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        DearFuture
                    </span>
                </div>
                
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-3 sm:px-4 py-2 text-indigo-600 hover:text-indigo-700 font-medium transition-colors text-sm sm:text-base"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-3 sm:px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors text-sm sm:text-base"
                        >
                            Sign In
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-4 sm:px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:from-indigo-600 hover:to-purple-700 font-medium transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base"
                        >
                            Get Started
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative px-4 sm:px-6 py-12 sm:py-20">
            <div class="max-w-7xl mx-auto text-center">
                <!-- Background Elements -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute -top-20 sm:-top-40 -right-20 sm:-right-40 w-40 h-40 sm:w-80 sm:h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-20 sm:-bottom-40 -left-20 sm:-left-40 w-40 h-40 sm:w-80 sm:h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="absolute top-20 sm:top-40 left-20 sm:left-40 w-40 h-40 sm:w-80 sm:h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
                </div>

                <div class="relative z-10">
                    <h1 class="text-4xl sm:text-5xl md:text-7xl font-bold text-gray-900 mb-4 sm:mb-6 px-4">
                        Send Messages to
                        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Tomorrow
                        </span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl md:text-2xl text-gray-600 mb-6 sm:mb-8 max-w-3xl mx-auto leading-relaxed px-4">
                        Create time capsules with messages, photos, and memories that will be delivered to your future self or loved ones at the perfect moment.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center px-4">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold text-base sm:text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                        >
                            Create Your First Capsule
                        </Link>
                        <Link
                            :href="route('login')"
                            class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 border-2 border-gray-300 text-gray-700 rounded-xl hover:border-indigo-500 hover:text-indigo-600 font-semibold text-base sm:text-lg transition-all duration-200"
                        >
                            Sign In
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="relative px-4 sm:px-6 py-12 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                        How It Works
                    </h2>
                    <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                        Simple steps to create meaningful time capsules that will be delivered at the perfect moment.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-3 sm:mb-4">Create</h3>
                        <p class="text-gray-600 leading-relaxed px-4">
                            Write your message, add photos, and set the perfect delivery date. Your capsule is securely stored until it's time.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-3 sm:mb-4">Wait</h3>
                        <p class="text-gray-600 leading-relaxed px-4">
                            Time passes, but your memories are safe. Our secure system ensures your capsule remains private until delivery.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-pink-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-3 sm:mb-4">Receive</h3>
                        <p class="text-gray-600 leading-relaxed px-4">
                            When the time comes, your capsule is delivered with a beautiful notification, bringing back precious memories.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Use Cases Section -->
        <div class="relative px-4 sm:px-6 py-12 sm:py-20 bg-gradient-to-br from-indigo-50 to-purple-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                        Perfect For
                    </h2>
                    <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                        Whether it's for yourself or someone special, time capsules create meaningful moments.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Future Self</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Send messages to yourself in the future</p>
                    </div>

                    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Loved Ones</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Share memories with family and friends</p>
                    </div>

                    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Milestones</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Celebrate birthdays and anniversaries</p>
                    </div>

                    <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Goals</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Track progress and achievements</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative px-4 sm:px-6 py-12 sm:py-20 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4 sm:mb-6">
                    Ready to Send a Message to Tomorrow?
                </h2>
                <p class="text-lg sm:text-xl text-indigo-100 mb-6 sm:mb-8 px-4">
                    Join thousands of people who are already creating meaningful time capsules.
                </p>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="inline-block px-6 sm:px-8 py-3 sm:py-4 bg-white text-indigo-600 rounded-xl hover:bg-gray-50 font-semibold text-base sm:text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                    Start Creating Now
                </Link>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white px-4 sm:px-6 py-8 sm:py-12">
            <div class="max-w-7xl mx-auto text-center">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-lg sm:text-xl font-bold">DearFuture</span>
                </div>
                <p class="text-gray-400 text-sm sm:text-base">
                    © 2024 DearFuture. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
