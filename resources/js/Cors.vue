<script>
import MenuPanel from "./components/MenuPanel.vue";
import FilterComponent from "./components/FilterComponent.vue";
import ModalWindow from "./components/ModalWindowComponent.vue";

export default {
    components: {
        ModalWindow,
        MenuPanel,
        FilterComponent
    },

    data() {
        return {
            urls: [],
            currentUser: window.Laravel.user,
            isAuthenticated: Boolean(window.Laravel.signedIn),
            currentSearch: '',
            currentSort: '',
            form: {
                url: ''
            },
            loading: false,
            showModal: false,
            selectedUrl: null  // Для хранения выбранного URL
        }
    },

    computed: {
        searchMessage() {
            let result = [...this.urls];

            if (this.currentSearch) {
                const search = this.currentSearch.toLowerCase();
                result = result.filter(url =>
                    (url.url || '').toLowerCase().includes(search)
                );
            }

            if (this.currentSort === 'created_at') {
                result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }

            if (this.currentSort === 'title') {
                result.sort((a, b) => (a.url || '').localeCompare(b.url || ''));
            }

            return result;
        }
    },

    methods: {
        async fetchCors() {
            try {
                const response = await fetch('http://restapi.local/api/cors');
                if (!response.ok) throw new Error('Не удалось загрузить данные');
                this.urls = await response.json();
            } catch (error) {
                console.error(error);
                alert('Ошибка при загрузке данных');
            }
        },

        async postCors() {
            if (!this.form.url.trim()) {
                alert('Введите URL');
                return;
            }

            this.loading = true;

            try {
                const res = await fetch('http://restapi.local/api/cors', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        url: this.form.url.trim()
                    })
                });

                if (!res.ok) {
                    const errorText = await res.text();
                    throw new Error(errorText || 'Ошибка при отправке');
                }

                const data = await res.json();

                this.form.url = '';
                await this.fetchCors();

            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },

        async deleteUrl(urlId) {
            try {
                const response = await fetch(`http://restapi.local/api/cors/${urlId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Не удалось удалить');

                this.urls = this.urls.filter(r => r.id !== urlId);
            } catch (e) {
                console.log(e);
                alert('Ошибка при удалении');
            }
        },

        openEditModal(url) {
            this.selectedUrl = { ...url };
            this.showModal = true;
        },

        async saveEditedUrl() {
            if (!this.selectedUrl.url.trim()) {
                alert('Введите URL');
                return;
            }

            try {
                const response = await fetch(`http://restapi.local/api/cors/${this.selectedUrl.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        url: this.selectedUrl.url.trim()
                    })
                });

                if (!response.ok) throw new Error('Не удалось обновить');

                await this.fetchCors();
                this.showModal = false;
                this.selectedUrl = null;
            } catch (e) {
                console.log(e);
                alert('Ошибка при обновлении');
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
        }
    },

    mounted() {
        this.fetchCors();
    }
}
</script>

<template>
    <div class="container flex min-h-screen">
        <menu-panel open-panel="true" :user="currentUser" :isAuthenticated="isAuthenticated"/>

        <div class="main w-full p-6">
            <filter-component v-model:search="currentSearch" v-model:sort.lazy="currentSort"/>

            <form @submit.prevent="postCors" class="mt-6">
                <div class="flex gap-3">
                    <input type="url" v-model="form.url" placeholder="Добавьте URL адрес сайта" class="flex-1 border border-slate-200 rounded-lg px-4 py-2.5 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" :disabled="loading" required>
                    <button type="submit" :disabled="loading || !form.url.trim()" class="bg-slate-600 disabled:bg-slate-400 text-white px-6 py-2.5 rounded-lg font-medium transition-all flex items-center gap-2">
                        <span v-if="loading">Добавление...</span>
                        <span v-else>Добавить</span>
                    </button>
                </div>
            </form>

            <div class="sites mt-6 space-y-3">
                <div v-for="site in urls" :key="site.id" class="sites-card bg-white rounded-lg border border-slate-200 p-4 flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-slate-700 font-medium">{{ site.url }}</p>
                        <p class="text-xs text-slate-400 mt-1">Добавлен: {{ formatDate(site.created_at) }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button @click="openEditModal(site)" class="p-2 rounded-md border border-slate-200 bg-white cursor-pointer" title="Редактировать">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-slate-600">
                                <path d="M18.3639 5.63604C19.2446 6.51669 19.2446 7.91942 18.3639 8.80007L9.75736 17.4066L4 19L5.59336 13.2426L14.1999 4.63604C15.0806 3.75539 16.4833 3.75539 17.3639 4.63604Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13 7L17 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <button @click="deleteUrl(site.id)" class="p-2 rounded-md border border-slate-200 bg-white cursor-pointer" title="Удалить">
                            <svg class="w-4.5 h-4.5 text-red-400" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="urls.length === 0" class="text-center py-12 mt-6">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.66 0 3-4 3-9s-1.34-9-3-9m0 18c-1.66 0-3-4-3-9s1.34-9 3-9"/>
                </svg>
                <p class="text-slate-500">Нет добавленных URL</p>
                <p class="text-sm text-slate-400 mt-1">Добавьте первый URL с помощью формы выше</p>
            </div>

            <modal-window v-model="showModal" title="Редактирование URL" width="max-w-lg" @close="selectedUrl = null">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            URL адрес
                        </label>
                        <input type="url" v-model="selectedUrl.url" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500" placeholder="https://example.com">
                    </div>

                    <div v-if="selectedUrl?.created_at">
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Дата создания
                        </label>
                        <p class="text-sm text-slate-500">{{formatDate(selectedUrl.created_at)}}</p>
                    </div>
                </div>

                <template #footer>
                    <div class="flex gap-2">
                        <button @click="showModal = false" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors">Отмена
                        </button>
                        <button @click="saveEditedUrl" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors" :disabled="!selectedUrl?.url.trim()">
                            Сохранить
                        </button>
                    </div>
                </template>
            </modal-window>
        </div>
    </div>
</template>

<style scoped>

</style>
