<script>
import MenuPanel from "./components/MenuPanel.vue";
import FilterComponent from "./components/FilterComponent.vue";

export default {
    components: {
        MenuPanel,
        FilterComponent
    },

    data() {
        return {
            replies: [],
            currentUser: window.Laravel.user,
            isAuthenticated: Boolean(window.Laravel.signedIn),
            currentSearch: '',
            currentSort: '',
            showOriginalMessage: null
        }
    },

    computed: {
        searchMessage() {
            let result = [...this.replies];

            if (this.currentSearch) {
                const search = this.currentSearch.toLowerCase();
                result = result.filter(reply => {
                    return (
                        (reply.title || '').toLowerCase().includes(search) ||
                        (reply.message || '').toLowerCase().includes(search) ||
                        (reply.email_reply || '').toLowerCase().includes(search)
                    );
                });
            }

            if (this.currentSort === 'created_at') {
                result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }

            if (this.currentSort === 'title') {
                result.sort((a, b) => (a.title || '').localeCompare(b.title || ''));
            }

            return result;
        }
    },

    methods: {
        async fetchReplies() {
            try {
                const response = await fetch('http://restapi.local/api/replies');
                if (!response.ok) throw new Error('Не удалось загрузить ответы');
                this.replies = await response.json();
            } catch (error) {
                console.error(error);
                alert('Ошибка при загрузке ответов');
            }
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

        async deleteReply(replyId) {

            try {
                const response = await fetch(`http://restapi.local/api/replies/${replyId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Не удалось удалить');

                this.replies = this.replies.filter(r => r.id !== replyId);
            } catch (error) {
                console.error(error);
            }
        }
    },
    mounted() {
        this.fetchReplies();
    }
}
</script>

<template>
    <div class="container flex h-[100vh]">
        <menu-panel open-panel="true" :user="currentUser" :isAuthenticated="isAuthenticated"></menu-panel>

        <div class="main w-full p-5">
            <filter-component v-model:search="currentSearch" v-model:sort.lazy="currentSort"/>

            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Мои ответы</h2>
                <div class="text-sm text-gray-500">
                    Всего ответов: <span class="font-semibold text-gray-700">{{ searchMessage.length }}</span>
                </div>
            </div>

            <div class="space-y-4">
                <div v-for="reply in searchMessage" :key="reply.id" class="bg-white rounded-lg border border-slate-100 overflow-hidden">
                    <div class="px-6 py-3">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ reply.title || 'Без темы' }}</h3>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ formatDate(reply.created_at) }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="px-6 py-4">

                        <div class="mb-4 flex items-start space-x-2">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            <div class="flex items-center">
                                <p class="text-sm text-gray-500 me-3">Кому:</p>
                                <p class="text-gray-700">{{reply.email_reply}}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">Текст ответа:</p>
                            <div class="bg-slate-50 rounded-lg p-4 border-l-[3px] border-slate-400">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ reply.message}}</p>
                            </div>
                        </div>
                        <div class="flex items-end justify-end">
                            <button
                                @click="deleteReply(reply.id)"
                                class="p-1.5 rounded-lg border border-gray-200 bg-white transition-all duration-200">
                                <svg class="w-4 h-4 text-red-400 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div v-if="searchMessage.length === 0" class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-lg">Нет ответов</p>
                <p class="text-gray-400 text-sm mt-2">У вас пока нет отправленных ответов</p>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
