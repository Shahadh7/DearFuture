<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    ClockIcon,
    LockClosedIcon,
    EnvelopeOpenIcon,
    PencilSquareIcon,
    CalendarDaysIcon,
    CalendarIcon,
    ExclamationCircleIcon,
    PlusIcon,
    ArrowRightIcon,
    CheckCircleIcon,
    UserCircleIcon,
    ViewfinderCircleIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            locked: 0,
            unlocked: 0,
            drafts: 0,
            delivered_today: 0,
            delivered_this_week: 0,
            failed_deliveries: 0
        })
    },
    recentActivity: {
        type: Array,
        default: () => []
    }
});

const capsuleStats = [
    { name: 'Total Capsules', stat: props.stats.total, icon: ClockIcon, color: 'text-indigo-500' },
    { name: 'Locked', stat: props.stats.locked, icon: LockClosedIcon, color: 'text-green-500' },
    { name: 'Unlocked', stat: props.stats.unlocked, icon: EnvelopeOpenIcon, color: 'text-blue-500' },
    { name: 'Drafts', stat: props.stats.drafts, icon: PencilSquareIcon, color: 'text-yellow-500' },
];

const deliveryStats = [
    { name: 'Delivered Today', stat: props.stats.delivered_today, icon: CalendarDaysIcon, color: 'text-emerald-500' },
    { name: 'Delivered This Week', stat: props.stats.delivered_this_week, icon: CalendarIcon, color: 'text-purple-500' },
    { name: 'Failed Deliveries', stat: props.stats.failed_deliveries, icon: ExclamationCircleIcon, color: 'text-red-500' },
];

const quickActions = [
    { 
        href: 'capsules.create',
        title: 'Create New Capsule',
        subtitle: 'Send a message to tomorrow',
        icon: PlusIcon,
        color: 'text-indigo-500',
        hoverBg: 'hover:bg-indigo-50'
    },
    { 
        href: 'capsules.index',
        title: 'View All Capsules',
        subtitle: 'Manage your time capsules',
        icon: ViewfinderCircleIcon,
        color: 'text-blue-500',
        hoverBg: 'hover:bg-blue-50'
    },
    { 
        href: 'profile.edit',
        title: 'Edit Profile',
        subtitle: 'Update your information',
        icon: UserCircleIcon,
        color: 'text-green-500',
        hoverBg: 'hover:bg-green-50'
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-bold text-gray-900">
                Welcome back, {{ $page.props.auth.user.name }}!
            </h2>
            <p class="mt-2 text-gray-600">
                Manage your time capsules and create new memories for the future.
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-8">
                    <!-- Stats Section -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Capsule Overview</h3>
                        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div v-for="item in capsuleStats" :key="item.name" class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <component :is="item.icon" class="h-6 w-6" :class="item.color" aria-hidden="true" />
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ item.name }}</dt>
                                                <dd class="text-2xl font-bold text-gray-900">{{ item.stat }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Stats -->
                     <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Delivery Report</h3>
                        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div v-for="item in deliveryStats" :key="item.name" class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <component :is="item.icon" class="h-6 w-6" :class="item.color" aria-hidden="true" />
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ item.name }}</dt>
                                                <dd class="text-2xl font-bold text-gray-900">{{ item.stat }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main content grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Quick Actions -->
                        <div class="lg:col-span-1 space-y-6">
                            <div class="bg-white rounded-lg shadow">
                               <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                                    <ul class="space-y-4">
                                        <li v-for="action in quickActions" :key="action.href">
                                            <Link :href="route(action.href)" class="group flex items-center justify-between p-4 bg-gray-50 rounded-lg transition" :class="action.hoverBg">
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ action.title }}</p>
                                                    <p class="text-sm text-gray-600">{{ action.subtitle }}</p>
                                                </div>
                                                <component :is="action.icon" class="h-6 w-6 group-hover:scale-110 transition-transform" :class="action.color" />
                                            </Link>
                                        </li>
                                    </ul>
                               </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="lg:col-span-2">
                             <div class="bg-white rounded-lg shadow">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                                    <div v-if="recentActivity.length > 0">
                                        <ul class="flow-root">
                                            <li v-for="(activity, index) in recentActivity" :key="activity.id" class="relative pb-8">
                                                <div v-if="index !== recentActivity.length - 1" class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-200"></div>
                                                <div class="relative flex items-start space-x-3">
                                                     <div>
                                                        <span :class="[activity.status === 'delivered' ? 'bg-green-500' : 'bg-red-500', 'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white']">
                                                             <CheckCircleIcon v-if="activity.status === 'delivered'" class="h-5 w-5 text-white" />
                                                             <ExclamationCircleIcon v-else class="h-5 w-5 text-white" />
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div>
                                                            <div class="text-sm">
                                                                <p class="font-medium text-gray-900">{{ activity.title }}</p>
                                                            </div>
                                                            <p class="mt-0.5 text-sm text-gray-500">{{ activity.description }}</p>
                                                        </div>
                                                        <div class="mt-2 text-sm text-gray-500">
                                                           {{ activity.date }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div v-else class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No recent activity</h3>
                                        <p class="mt-1 text-sm text-gray-500">Start creating time capsules to see your activity here.</p>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 