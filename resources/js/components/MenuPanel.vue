<script>
import LinkComponent from "./LinkComponent.vue";
export default {
    components: {LinkComponent},
    props: {
        openPanel: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            logoutUrl: '/user/logout',
            authUrl: '/user/authorization',
            regAuth: '/user/registration'
        }
    }
}
</script>

<template>
    <div class="menu w-3xs p-12 bg-slate-400 h-[100vh]">
        <div class="username">
            <img src="">
            <div class="main text-white">
                <p class="main-name text-2xl">Тест Тест</p>
                <p class="role">администратор</p>
            </div>
        </div>
        <div class="link-bar flex flex-col mt-6 text-white">
            <link-component class="mt-4" title="Сообщения" url="#"/>
            <link-component class="mt-4" title="Новости" url="#"/>
            <link-component class="mt-4" title="Пользователи" url="#"/>
            <link-component class="mt-4" title="Авторизация" :url="authUrl"/>
            <link-component class="mt-4" title="Регистрация" :url="regAuth"/>
            <link-component class="mt-4" title="Выход" :url="logoutUrl"/>
        </div>
    </div>
</template>

<style scoped>

</style>
