<script>
import SlideComponent from "./SlideComponent.vue";

export default{
    components: {
        SlideComponent
    },
    props: {
        messages: {
            type: Array,
            required: true,
            default: ()=>[]
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
            this.$emit('message-selected', message)
        },
        closeSlide() {
            this.openSlideMessage = false;
            this.selectedMessage = null;
        },
        deleteMessage(messegeId) {
            this.$emit('message:delete', messegeId)
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
    },

    computed: {
    }

}
</script>

<template>
    <div class="messages flex border border-slate-100 rounded-md">
        <div class="card-message w-1/2" :class="{'full': !openSlideMessage, 'shrink': openSlideMessage}">
            <div class="card border-b border-slate-100 p-3 p-2 flex justify-between" v-for="message in messages" :key="message.id">
                <div class="message-user">
                    <a class="title font-bold text-lg decoration-0 cursor-pointer" @click="openSlide(message)">{{message.title}}</a>
                    <div class="mb-4 flex items-start space-x-2 mt-2">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        <div class="flex items-center">
                            <p class="text-gray-700 text-sm">{{message.email_send}}</p>
                        </div>
                    </div>
                    <div class="message-text border-l-[3px] rounded-md p-3 border-slate-400 bg-slate-100 block-inline max-w-">
                        <p class="message text-md">{{message.message.slice(0, 120)}}...</p>
                    </div>
                </div>
                <p class="date text-sm">{{formatDate(message.created_at)}}</p>
            </div>
        </div>

        <slide-component :open_slide="openSlideMessage"  v-if="openSlideMessage" :message="selectedMessage" @close="closeSlide"  @deleted="deleteMessage" class="w-1/2"></slide-component>
    </div>
</template>

<style scoped>

</style>
