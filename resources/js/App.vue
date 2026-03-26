<script>
import LinkComponent from "./components/LinkComponent.vue";
import MenuPanel from "./components/MenuPanel.vue";
export default {
    components: {
        MenuPanel,
        LinkComponent
    },

    data() {
        return {
            messages: [],
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
        <ul>
            <li v-for="msg in messages" :key="msg.id" class="border border-slate-600 p-2 rounded-sm mt-3 w-full">title: {{msg.title}} message: {{msg.message}}</li>
        </ul>
    </div>
</template>
