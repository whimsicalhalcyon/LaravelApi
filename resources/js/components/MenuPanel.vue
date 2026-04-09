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
            regAuth: '/user/registration',
            newMessageUrl: '/',
            repliesUrl: '/emails/reply',
            corsUrl: '/cors',
            widgetUrl: '/widgets/iframe_demo'
        }
    }
}
</script>

<template>
    <div class="menu w-[35vh] p-10 bg-slate-400">
        <!-- Пользователь -->
        <div class="username flex items-center mb-6">
            <div class="main text-white">
                <p class="main-name text-xl mb-1">{{ user?.fullname }}</p>
                <span class="role bg-slate-50 p-1 text-slate-400 rounded text-xs">администратор</span>
            </div>
        </div>

        <div class="link-bar flex flex-col mt-4 text-white space-y-2">

            <a v-if="isAuthenticated" :href="newMessageUrl" class="flex items-center gap-3 p-2">
                <img src="/resources/img/svg/message.svg" alt="" class="w-4 h-4">
                <span>Входящие</span>
            </a>

            <a v-if="isAuthenticated" :href="repliesUrl" class="flex items-center gap-3 p-2 ">
                <img src="/resources/img/svg/reply.svg" alt="" class="w-4 h-4">
                <span>Отправленные</span>
            </a>

            <a v-if="isAuthenticated" :href="corsUrl" class="flex items-center gap-3 p-2 ">
                <img src="/resources/img/svg/planet.svg" alt="" class="w-4 h-4">
                <span>Доступные сайты</span>
            </a>

            <a v-if="!isAuthenticated" :href="authUrl" class="flex items-center gap-3 p-2 ">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V7m0 4v4m-6 0h12"/>
                </svg>
                <span>Авторизация</span>
            </a>

            <a v-if="!isAuthenticated" :href="regAuth" class="flex items-center gap-3 p-2 ">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5v14"/>
                </svg>
                <span>Регистрация</span>
            </a>

            <a v-if="isAuthenticated" :href="logoutUrl" class="flex items-center gap-3 p-2 ">
                <img src="/resources/img/svg/exit.svg" alt="" class="w-4 h-4">
                <span>Выход</span>
            </a>

        </div>
    </div>
</template>

<style scoped>

</style>
