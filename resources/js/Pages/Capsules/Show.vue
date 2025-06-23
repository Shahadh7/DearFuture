<template>
    <Head :title="capsule.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ capsule.title }}</h2>
                    <p class="mt-2 text-gray-600">Time capsule details</p>
                </div>
                <Link 
                    :href="route('capsules.index')" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-all duration-200"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Capsules
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full"
                                  :class="{
                                      'bg-yellow-100 text-yellow-800': capsule.status === 'draft',
                                      'bg-blue-100 text-blue-800': capsule.status === 'locked',
                                      'bg-green-100 text-green-800': capsule.status === 'delivered'
                                  }">
                                {{ capsule.status }}
                            </span>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 6v6m-4-6h8m-8 6h8" />
                                </svg>
                                Unlocks {{ formattedUnlockDate }}
                            </div>
                        </div>
                    </div>

                    <div v-if="isUnlocked" class="space-y-6">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-200/50">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Your Message</h3>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ capsule.message }}</p>
                        </div>

                        <div v-if="capsule.media && capsule.media.length" class="bg-white rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Attachments</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div 
                                    v-for="medium in capsule.media" 
                                    :key="medium.id" 
                                    class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
                                >
                                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                    </div>
                                    <a 
                                        :href="`/storage/${medium.id}/${medium.file_name}`" 
                                        target="_blank" 
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors"
                                    >
                                        {{ medium.file_name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center py-12">
                        <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6.364-6.364l-1.414 1.414M21 12h-2m-1.636-6.364l-1.414-1.414M12 3v2m6.364 6.364l1.414 1.414M3 12H1m1.636 6.364l1.414-1.414" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ new Date() >= new Date(capsule.unlock_date) ? 'This capsule is being processed' : 'This capsule is still locked' }}
                        </h3>
                        <p class="text-gray-600">
                            {{ new Date() >= new Date(capsule.unlock_date) ? 'It will be available shortly' : `It will be available on ${formattedUnlockDate}` }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    capsule: {
        type: Object,
        required: true,
    },
});

const isUnlocked = computed(() => {
    return new Date() >= new Date(props.capsule.unlock_date) && props.capsule.status === 'delivered';
});

const formattedUnlockDate = computed(() => {
    return new Date(props.capsule.unlock_date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
});
</script> 