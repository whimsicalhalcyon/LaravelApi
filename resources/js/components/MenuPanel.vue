<script>
import LinkComponent from "./LinkComponent.vue";
export default {
    components: {LinkComponent},
    props: {
        openPanel: {
            type: Boolean,
            default: false
        },
        user: {
            type: Object,
        },
        isAuthenticated: {
            type: Boolean
        }
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
    <div class="menu w-[320px] p-12 bg-slate-400 h-[100vh]">
        <div class="username">
            <img src="">
            <div class="main text-white">
                <p class="main-name text-xl mb-2">{{user?.fullname}}</p>
                <span class="role bg-slate-50 p-1 text-slate-400 rounded-xs text-xs mt-3">администратор</span>
            </div>
        </div>
        <div class="link-bar flex flex-col mt-6 text-white">
            <link-component v-if="isAuthenticated" class="mt-4" title="Входящие сообщения" url="#"/>
            <link-component v-if="isAuthenticated" class="mt-4" title="Отправленные сообщения" url="#"/>
            <link-component v-if="isAuthenticated" class="mt-4" title="Новости" url="#"/>
            <link-component v-if="isAuthenticated" class="mt-4" title="Доступные сайты" url="#"/>
            <link-component  v-if="isAuthenticated" class="mt-4" title="Пользователи" url="#"/>
            <link-component v-if="!isAuthenticated" class="mt-4" title="Авторизация" :url="authUrl"/>
            <link-component v-if="!isAuthenticated" class="mt-4" title="Регистрация" :url="regAuth"/>
            <link-component v-if="isAuthenticated" class="mt-4" title="Выход" :url="logoutUrl"/>
        </div>
    </div>
</template>

<style scoped>

</style>
