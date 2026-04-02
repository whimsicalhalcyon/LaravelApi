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
            iframeCode: `<iframe src="/widgets/contact" width="100%" height="500" frameborder="0" style="border: 1px solid #e2e8f0; border-radius: 0.5rem;" title="Форма обратной связи"></iframe>`
        }
    },
    methods: {

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
        copyIframeCode() {
            navigator.clipboard.writeText(this.iframeCode).then(() => {
                alert('Код iframe скопирован!');
            }).catch(() => {
                alert('Не удалось скопировать код');
            });
        },

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
        }
    }
}
</script>

<template>
    <div class="container flex">
        <menu-panel open-panel="true" :user="currentUser" :isAuthenticated="isAuthenticated"/>

        <div class="main w-full p-5">
            <div class="widget">
                <div class="card bg-base-100 w-2xl border border-slate-100 p-4 rounded-sm">
                    <div class="card-body">
                        <h2 class="card-title">Форма</h2>

                        <div class="mt-4">
                            <div class="bg-gray-50 rounded-lg p-2 mb-2">
                                <pre class="text-sm whitespace-pre-wrap font-mono">{{iframeCode}}</pre>
                            </div>
                            <iframe
                                src="/widgets/contact"
                                width="100%"
                                height="400"
                                frameborder="0"
                                style="border: 1px solid #e2e8f0; border-radius: 0.5rem;"
                                title="Форма обратной связи"
                                class="p-5"
                            ></iframe>
                        </div>

                        <div class="card-actions justify-end">
                            <button @click="copyIframeCode" class="btn btn-primary p-2 bg-slate-400 text-white rounded-sm mt-3">Скопировать код</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
