<template>
  <Head :title="capsule.title" />
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 flex flex-col items-center justify-center py-8 relative overflow-hidden">
    <!-- Background Blobs -->
    <div class="absolute -top-20 sm:-top-40 -right-20 sm:-right-40 w-40 h-40 sm:w-80 sm:h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute -bottom-20 sm:-bottom-40 -left-20 sm:-left-40 w-40 h-40 sm:w-80 sm:h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute top-20 sm:top-40 left-20 sm:left-40 w-40 h-40 sm:w-80 sm:h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10 bg-white rounded-xl shadow-sm border border-gray-200/50 p-8 w-full max-w-2xl">
      <h1 class="text-3xl font-bold text-gray-900 mb-2 text-center">{{ capsule.title }}</h1>
      <p class="text-gray-600 mb-6 text-center">Unlocked Capsule</p>

      <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-200/50 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Message</h3>
        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ capsule.message }}</p>
      </div>

      <div v-if="capsule.media && capsule.media.length" class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Attachments</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div v-for="medium in capsule.media" :key="medium.id" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
              </svg>
            </div>
            <a :href="`/storage/${medium.id}/${medium.file_name}`" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              {{ medium.file_name }}
            </a>
          </div>
        </div>
      </div>

      <div v-if="capsule.user" class="text-sm text-gray-500 text-center mt-8">
        <span>Sent by: <span class="font-medium text-gray-700">{{ capsule.user.name }}</span></span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
const props = defineProps({
  capsule: {
    type: Object,
    required: true,
  },
});
</script>

<style scoped>
@keyframes blob {
  0%, 100% {
    transform: translateY(0px) scale(1);
  }
  33% {
    transform: translateY(-20px) scale(1.1);
  }
  66% {
    transform: translateY(10px) scale(0.9);
  }
}
.animate-blob {
  animation: blob 8s infinite;
}
.animation-delay-2000 {
  animation-delay: 2s;
}
.animation-delay-4000 {
  animation-delay: 4s;
}
</style> 