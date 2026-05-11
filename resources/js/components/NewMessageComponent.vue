<script>
import SlideComponent from "./SlideComponent.vue";

export default {
    components: {
        SlideComponent
    },
    props: {
        messages: {
            type: Array,
            required: true,
            default: () => []
        },
        search: {
            type: String,
            default: ''
        },
        sort: {
            type: String,
            default: ''
        }
    },
    emits: ['message:delete', 'message-selected'],

    data() {
        return {
            openSlideMessage: false,
            selectedMessage: null
        }
    },

    methods: {
        openSlide(message) {
            this.selectedMessage = message;
            this.openSlideMessage = true;
            this.$emit('message-selected', message);
        },

        closeSlide() {
            this.openSlideMessage = false;
            this.selectedMessage = null;
        },

        deleteMessage(messageId) {
            this.$emit('message:delete', messageId);
        },

        formatDate(date) {
            if (!date) return 'Дата неизвестна';
            return new Date(date).toLocaleString('ru-RU', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },

        getMessageType(categoryId) {
            switch (categoryId) {
                case 1:
                    return 'Ошибка';
                case 2:
                    return 'Обращение';
                case 3:
                    return 'Вопрос';
                default:
                    return 'Неизвестно';
            }
        },

        getMessageTypeClass(categoryId) {
            switch (categoryId) {
                case 1:
                    return 'bg-red-100 text-red-700';
                case 2:
                    return 'bg-blue-100 text-blue-700';
                case 3:
                    return 'bg-green-100 text-green-700';
                default:
                    return 'bg-gray-100 text-gray-700';
            }
        }
    }
}
</script>

<template>
    <div class="messages flex border border-gray-200 rounded-2xl overflow-hidden bg-white">
        <div
            :class="{
                'w-full transition-all duration-300 ease-in-out': !openSlideMessage,
                'w-1/2 transition-all duration-300 ease-in-out': openSlideMessage
            }"
        >
            <div
                v-for="message in messages"
                :key="message.id"
                @click="openSlide(message)"
                class="group border-b border-gray-200 last:border-b-0 p-5 cursor-pointer"
            >
                <div class="flex items-start justify-between gap-4">
                    <a class="font-semibold text-lg text-gray-900 group-hover:text-violet-700 transition-colors duration-200 line-clamp-1 flex-1">
                        {{ message.title }}
                    </a>

                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs px-2 py-1 rounded-full"
                            :class="getMessageTypeClass(message.category_id)"
                        >
                            {{ getMessageType(message.category_id) }}
                        </span>

                        <p class="text-sm text-gray-500 whitespace-nowrap flex-shrink-0 mt-1">
                            {{ formatDate(message.created_at) }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-3 text-sm">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400 flex-shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2.01 2.01 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2"/>
                    </svg>
                    <p class="text-gray-600 truncate">{{ message.email_send }}</p>
                </div>

                <div class="mt-3 pl-6 border-l-4 border-gray-300 bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                    {{ message.message.length > 200
                    ? message.message.slice(0, 135) + '...'
                    : message.message }}
                </div>
            </div>
        </div>

        <SlideComponent
            v-if="openSlideMessage"
            :open_slide="openSlideMessage"
            :message="selectedMessage"
            @close="closeSlide"
            @deleted="deleteMessage"
            class="w-1/2 border-l border-gray-200 bg-white"
        />
    </div>
</template>

<style scoped>
</style>
