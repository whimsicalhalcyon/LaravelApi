<script>
import LinkComponent from "./components/LinkComponent.vue";
import MenuPanel from "./components/MenuPanel.vue";
import SlideComponent from "./components/SlideComponent.vue";
import InputComponent from "./components/InputComponent.vue";
export default {
    components: {
        InputComponent,
        SlideComponent,
        MenuPanel,
        LinkComponent,
    },

    data() {
        return {
            messages: [],
            openSlideMessage: false,
            selectedMessage: null,
            isAuthenticated: Boolean(window.Laravel.signedIn),
            currentUser: window.Laravel.user,
            currentSearch: '',
            currentSort: '',
        }
    },
    methods: {
        async fetchData() {
            try {
                const res = await fetch('http://restapi.local/api/messages')
                if (!res.ok) throw new Error('Не загружено')
                this.messages = await res.json()
            } catch (error) {
                console.error(error)
                alert('Не удалось загрузить данные')
            }
        },
        openSlide(message) {
            this.selectedMessage = message;
            this.openSlideMessage = true;
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
        }
    }
}
</script>

<template>
    <div class="container flex">
        <menu-panel open-panel="true" :user="currentUser" :isAuthenticated="isAuthenticated"></menu-panel>
        <div class="main w-full p-5">
            <div class="navbar mt-5 mb-3 w-full">
                <input type="text" placeholder="Поиск" name="search" v-model="currentSearch"  class="w-2xs border border-slate-100 p-2 rounded-md w-1/2"/>
                <select id="search" v-model="currentSort" class="px-3 py-2.5 ms-3 bg-neutral-secondary-medium border border-slate-100 text-heading text-sm rounded-md focus:ring-brand focus:border-brand placeholder:text-body">
                    <option value="">Cортировать по</option>
                    <option value="created_at">Дате</option>
                    <option value="title">Названию</option>
                </select>
            </div>

            <div class="messages flex">
                <div class="card-message w-1/2" :class="{'full': !openSlideMessage, 'shrink': openSlideMessage}">
                    <div class="card border border-slate-100 p-3 p-2 flex justify-between" v-for="message in searchMessage" :key="message.id">
                        <div class="message-user">
                            <a class="title font-bold text-lg decoration-0 cursor-pointer" @click="openSlide(message)">{{message.title}}</a>
                            <p class="email_send text-slate-600 text-sm">{{message.email_send}}</p>
                            <p class="message text-md">{{message.message}}</p>
                        </div>
                        <p class="date text-sm">{{new Date(message.created_at).toISOString().split('T')[0]}}</p>
                    </div>
                </div>

                <slide-component :open_slide="openSlideMessage"  v-if="openSlideMessage" :message="selectedMessage" @close="openSlideMessage = false"  @deleted="messages = messages.filter(m => m.id !== $event)" class="w-1/2"></slide-component>
            </div>

        </div>
    </div>
</template>
