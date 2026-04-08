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
            iframeCode: `<iframe src="http://restapi.local/widget/contact" width="100%" height="500" frameborder="0" style="border: 1px solid #e2e8f0; border-radius: 0.5rem;" title="Форма обратной связи"></iframe>`
        }
    },
    methods: {
        copyIframeCode() {
            navigator.clipboard.writeText(this.iframeCode).then(() => {
                alert('Код iframe скопирован!');
            }).catch(() => {
                alert('Не удалось скопировать код');
            });
        },

    },
}
</script>

<template>
    <div class="container flex">
        <menu-panel open-panel="true" :user="currentUser" :isAuthenticated="isAuthenticated"/>

        <div class="main w-full p-5">
            <div class="widget">
                <div class="card bg-base-100 w-2xl border border-slate-100 p-4 rounded-sm">
                    <div class="card-body">
                        <h2 class="card-title">Форма обратной связи</h2>

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
