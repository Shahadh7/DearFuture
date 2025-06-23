<template>
    <form @submit.prevent="submit">
        <div class="space-y-8">
            <!-- Title Field -->
            <div>
                <InputLabel for="title" value="Capsule Title" class="text-lg font-semibold text-gray-900" />
                <p class="mt-1 text-sm text-gray-600">Give your time capsule a memorable title</p>
                <TextInput
                    id="title"
                    type="text"
                    class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    v-model="form.title"
                    required
                    autofocus
                    placeholder="e.g., My 30th Birthday Message"
                />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <!-- Message Field -->
            <div>
                <InputLabel for="message" value="Your Message" class="text-lg font-semibold text-gray-900" />
                <p class="mt-1 text-sm text-gray-600">Write the message you want to send to the future</p>
                <textarea
                    id="message"
                    class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm resize-none"
                    v-model="form.message"
                    rows="8"
                    required
                    placeholder="Dear future me, I hope you're doing well..."
                ></textarea>
                <InputError class="mt-2" :message="form.errors.message" />
            </div>

            <!-- Recipient Email Field -->
            <div>
                <InputLabel for="recipient_email" value="Recipient's Email (Optional)" class="text-lg font-semibold text-gray-900" />
                <p class="mt-1 text-sm text-gray-600">Send this capsule to someone else instead of yourself</p>
                <TextInput
                    id="recipient_email"
                    type="email"
                    class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    v-model="form.recipient_email"
                    placeholder="friend@example.com"
                />
                <InputError class="mt-2" :message="form.errors.recipient_email" />
            </div>

            <!-- Unlock Date Field -->
            <div>
                <InputLabel for="unlock_date" value="Unlock Date" class="text-lg font-semibold text-gray-900" />
                <p class="mt-1 text-sm text-gray-600">When should this capsule be delivered?</p>
                <TextInput
                    id="unlock_date"
                    type="datetime-local"
                    class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    v-model="form.unlock_date"
                    required
                    :min="minUnlockDate"
                />
                <InputError class="mt-2" :message="form.errors.unlock_date" />
            </div>

            <!-- Attachments Field -->
            <div>
                <InputLabel for="attachments" value="Attachments (Optional)" class="text-lg font-semibold text-gray-900" />
                <p class="mt-1 text-sm text-gray-600">Add photos, documents, or other files to your capsule</p>
                <input
                    type="file"
                    multiple
                    @input="form.attachments = $event.target.files"
                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-indigo-50 file:to-purple-50 file:text-indigo-700 hover:file:from-indigo-100 hover:file:to-purple-100 file:border file:border-indigo-200 transition-all duration-200"
                />
                <InputError class="mt-2" :message="form.errors.attachments" />
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    :disabled="form.processing" 
                    @click="form.status = 'locked'"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6.364-6.364l-1.414 1.414M21 12h-2m-1.636-6.364l-1.414-1.414M12 3v2m6.364 6.364l1.414 1.414M3 12H1m1.636 6.364l1.414-1.414" />
                    </svg>
                    Lock Capsule
                </button>
                
                <button 
                    type="submit" 
                    :disabled="form.processing" 
                    @click="form.status = 'draft'"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:border-indigo-500 hover:text-indigo-600 font-semibold transition-all duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Save as Draft
                </button>
                
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <div v-if="form.recentlySuccessful" class="flex items-center text-sm text-green-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Saved successfully!
                    </div>
                </Transition>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { computed } from 'vue';

const props = defineProps({
    capsule: {
        type: Object,
        default: null,
    },
});

const toLocalDateTimeString = (date) => {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    return `${year}-${month}-${day}T${hours}:${minutes}`;
};

const form = useForm({
    title: props.capsule?.title || '',
    message: props.capsule?.message || '',
    recipient_email: props.capsule?.recipient_email || '',
    unlock_date: props.capsule?.unlock_date ? toLocalDateTimeString(props.capsule.unlock_date) : '',
    status: props.capsule?.status || 'draft',
    attachments: [],
    _method: props.capsule ? 'patch' : 'post',
});

const minUnlockDate = computed(() => {
    const now = new Date();
    now.setMinutes(now.getMinutes() + 1); // Set minimum to 1 minute in the future
    return toLocalDateTimeString(now);
});

const submit = () => {
    const url = props.capsule
        ? route('capsules.update', props.capsule.id)
        : route('capsules.store');
    
    form.transform(data => ({
        ...data,
        unlock_date: data.unlock_date ? new Date(data.unlock_date).toISOString() : null,
    })).post(url, {
        preserveScroll: true,
    });
};
</script> 