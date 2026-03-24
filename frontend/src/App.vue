<template>
    <ul>
        <li v-for="message in messages" :key="message.id">
            {{ message.title }} ({{ message.message }})
        </li>
    </ul>
</template>

<script>
export default {
    data() {
        return {
            messages: []
        }
    },
    mounted() {
        this.$api.get('/messages')
            .then(response => {
                this.messages = response.data
            })
            .catch(error => {
                console.error('Ошибка при загрузке сообщений:', error)
            })
    }
}
</script>

<style scoped>
/* Можно добавить стили для списка */
ul {
    list-style: none;
    padding: 0;
}
li {
    margin-bottom: 8px;
    padding: 4px;
    border-bottom: 1px solid #ccc;
}
</style>
