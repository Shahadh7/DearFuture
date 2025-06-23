<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    capsules: Object,
    filters: Object,
});

const form = ref({
    search: props.filters.search || '',
    status: props.filters.status || '',
});

const filter = () => {
    router.get(route('capsules.index'), form.value, {
        preserveState: true,
        replace: true,
    });
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const deleteCapsule = (capsule) => {
    if (confirm(`Are you sure you want to delete "${capsule.title}"?`)) {
        router.delete(route('capsules.destroy', capsule.id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="My Capsules" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">My Capsules</h2>
                    <p class="mt-2 text-gray-600">Manage your time capsules and memories</p>
                </div>
                <Link 
                    :href="route('capsules.create')" 
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Capsule
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200/50 p-6 mb-8">
                    <form @submit.prevent="filter" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input
                                v-model="form.search"
                                type="text"
                                placeholder="Search by title..."
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select v-model="form.status" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                                <option value="">All Statuses</option>
                                <option value="draft">Draft</option>
                                <option value="locked">Locked</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button 
                                type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Capsules Grid -->
                <div v-if="capsules.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="capsule in capsules.data" 
                        :key="capsule.id"
                        class="bg-white rounded-xl shadow-sm border border-gray-200/50 hover:shadow-lg transition-shadow duration-200"
                    >
                        <div class="p-6">
                            <!-- Status Badge -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                      :class="{
                                          'bg-yellow-100 text-yellow-800': capsule.status === 'draft',
                                          'bg-blue-100 text-blue-800': capsule.status === 'locked',
                                          'bg-green-100 text-green-800': capsule.status === 'delivered'
                                      }">
                                    {{ capsule.status }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <Link 
                                        :href="route('capsules.show', capsule.id)" 
                                        class="text-gray-400 hover:text-indigo-600 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </Link>
                                    <Link 
                                        v-if="capsule.status === 'draft'" 
                                        :href="route('capsules.edit', capsule.id)" 
                                        class="text-gray-400 hover:text-indigo-600 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </Link>
                                    <button 
                                        v-if="capsule.status === 'draft'" 
                                        @click="deleteCapsule(capsule)" 
                                        class="text-gray-400 hover:text-red-600 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ capsule.title }}</h3>

                            <!-- Unlock Date -->
                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 6v6m-4-6h8m-8 6h8" />
                                </svg>
                                Unlocks {{ formatDate(capsule.unlock_date) }}
                            </div>

                            <!-- Recipient -->
                            <div v-if="capsule.recipient_email" class="flex items-center text-sm text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                For {{ capsule.recipient_email }}
                            </div>

                            <!-- View Button -->
                            <Link 
                                :href="route('capsules.show', capsule.id)" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 text-indigo-700 rounded-lg hover:from-indigo-100 hover:to-purple-100 font-medium transition-all duration-200"
                            >
                                View Capsule
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-xl shadow-sm border border-gray-200/50 p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No capsules yet</h3>
                    <p class="mt-2 text-gray-600">Start creating your first time capsule to send messages to tomorrow.</p>
                    <div class="mt-6">
                        <Link
                            :href="route('capsules.create')"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Your First Capsule
                        </Link>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="capsules.links.length > 3" class="mt-8 flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Showing {{ capsules.from }} to {{ capsules.to }} of {{ capsules.total }} results
                    </div>
                    <div class="flex space-x-1">
                        <template v-for="(link, index) in capsules.links" :key="index">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                v-html="link.label"
                                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                                :class="{
                                    'bg-indigo-500 text-white': link.active,
                                    'text-gray-700 hover:bg-gray-100': !link.active
                                }"
                            />
                             <span
                                v-else
                                v-html="link.label"
                                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors text-gray-400 cursor-not-allowed"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 