<script>
import LinkComponent from "./components/LinkComponent.vue";
import MenuPanel from "./components/MenuPanel.vue";
import SlideComponent from "@/components/SlideComponent.vue";
import InputComponent from "@/components/InputComponent.vue";
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
            openSlideMessage: false
        }
    },
    methods: {
        async fetchData() {
            try {
                const res = await fetch('http://restapi.local/messages')
                if (!res.ok) throw new Error('Не загружено')
                this.messages = await res.json()
            } catch (error) {
                console.error(error)
                alert('Не удалось загрузить данные')
            }
        },
        openSlide() {
            this.openSlideMessage = !this.openSlideMessage
            console.log(this.openSlideMessage)
        }
    },
    mounted() {
        this.fetchData()
    }
}
</script>

<template>
    <div class="container flex">
        <menu-panel open-panel="true"></menu-panel>
        <div class="main w-full p-5">
            <div class="navbar mt-5 mb-3 w-full">
                <input-component type="text" placeholder="Поиск" name="search" />
                <input type="text" placeholder="Поиск" class="border border-slate-100 p-2 rounded-md w-1/2">
                <input type="date" placeholder="Дата" class="border border-slate-100 p-2 rounded-md ms-2">
                <input type="date" placeholder="Дата" class="border border-slate-100 p-2 rounded-md ms-2">
            </div>

            <div class="messages flex">
                <div class="card-message w-1/2">
                    <div class="card border border-slate-100 p-3 p-2 flex justify-between" v-for="message in messages" :key="message.id">
                        <div class="message-user">
                            <a class="title font-bold text-xl decoration-0 cursor-pointer" @click="openSlide">{{message.title}}</a>
                            <p class="email_send text-slate-600">{{message.email_send}}</p>
                            <p class="message">{{message.message}}</p>
                        </div>
                        <p>{{message.created_at}}</p>
                    </div>
                </div>

                <slide-component :open_slide="openSlideMessage" class="w-1/2"></slide-component>
            </div>

        </div>
    </div>
</template>
