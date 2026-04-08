<script>
import MenuPanel from "./components/MenuPanel.vue";
import FilterComponent from "./components/FilterComponent.vue";
import NewMessageComponent from "./components/NewMessageComponent.vue";

export default {
    components: {
        FilterComponent,
        MenuPanel,
        NewMessageComponent
    },

    data() {
        return {
            messages: [],
            isAuthenticated: Boolean(window.Laravel.signedIn),
            currentUser: window.Laravel.user,
            currentSearch: '',
            currentSort: '',
            currentPage: 1,
            perPage: 5
        }
    },
    methods: {
        async fetchData() {
            try {
                const res = await fetch('http://restapi.local/api/messages')
                if (!res.ok) throw new Error('Не загружено')
                this.messages = await res.json()
                console.log('Загружено сообщений:', this.messages.length)
            } catch (error) {
                console.error(error)
                alert('Не удалось загрузить данные')
            }
        },

        handleMessageDelete(messageId) {
            this.messages = this.messages.filter(m => m.id !== messageId)
            console.log('Сообщение удалено, осталось:', this.messages.length)
        },

        handleMessageSelected(message) {
            console.log('Выбрано сообщение:', message)
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
    mounted() {
        this.fetchData()
    },
    computed: {
        searchMessage() {
            let result = [...this.messages];

            if (this.currentSearch) {
                const search = this.currentSearch.toLocaleLowerCase();
                result = result.filter(message => {
                    return (
                        (message.title || '').toLocaleLowerCase().includes(search) ||
                        (message.message || '').toLocaleLowerCase().includes(search) ||
                        (message.email_send || '').toLocaleLowerCase().includes(search)
                    );
                });
            }

            if (this.currentSort === 'created_at') {
                result.sort((a, b) => {
                    return new Date(b.created_at) - new Date(a.created_at);
                });
            }

            if (this.currentSort === 'title') {
                result.sort((a, b) => {
                    return (a.title || '').localeCompare(b.title || '');
                });
            }

            return result;
        },

        getPaginateMessage() {
            const start = (this.currentPage - 1) * this.perPage
            return this.searchMessage.slice(start, start + this.perPage)
        },

        getTotalPages() {
            return Math.ceil(this.searchMessage.length/this.perPage)
        }
    }
}
</script>

<template>
    <div class="container flex h-[100vh]">
        <menu-panel open-panel="true" :user="currentUser" :isAuthenticated="isAuthenticated"/>

        <div class="main w-full p-5">
            <filter-component v-model:search="currentSearch" v-model:sort.lazy="currentSort"/>
            <new-message-component :messages="getPaginateMessage" :search="currentSearch" :sort="currentSort" @message:delete="handleMessageDelete" @message-selected="handleMessageSelected"/>

            <div class="flex justify-center gap-2 mt-4">
                <button  v-for="page in getTotalPages"  :key="page" @click="currentPage = page" :class="['px-3 py-1 rounded transition cursor-pointer', currentPage === page ? 'bg-slate-200 text-black cursor-pointer' : 'bg-slate-300 hover:bg-slate-300 cursor-pointer' ]">
                    {{ page }}
                </button>
            </div>
        </div>
    </div>
</template>
