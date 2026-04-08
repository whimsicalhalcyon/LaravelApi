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
    <div class="menu w-[320px] p-12 bg-slate-400">
        <div class="username">
            <img src="">
            <div class="main text-white">
                <p class="main-name text-xl mb-2">{{user?.fullname}}</p>
                <span class="role bg-slate-50 p-1 text-slate-400 rounded-xs text-xs mt-3">администратор</span>
            </div>
        </div>
        <div class="link-bar flex flex-col mt-6 text-white">
            <div class="link flex w-full items-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <link-component v-if="isAuthenticated" class="mt-4" title="Входящие сообщения" :url="newMessageUrl"/>
            </div>

            <div class="link flex w-full items-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7M12 19v-6M12 5v4"/>
                </svg>
                <link-component v-if="isAuthenticated" class="mt-4" title="Отправленные сообщения" :url="repliesUrl"/>
            </div>

            <div class="link flex items-center w-full">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="3" y1="9" x2="21" y2="9" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="9" y1="3" x2="9" y2="21" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <link-component v-if="isAuthenticated" class="mt-4" title="Доступные сайты" :url="corsUrl"/>
            </div>

            <div class="link flex items-center w-full">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="3" y1="9" x2="21" y2="9" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="9" y1="3" x2="9" y2="21" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <link-component v-if="isAuthenticated" class="mt-4" title="Виджеты" :url="widgetUrl"/>
            </div>

            <link-component v-if="!isAuthenticated" class="mt-4" title="Авторизация" :url="authUrl"/>
            <link-component v-if="!isAuthenticated" class="mt-4" title="Регистрация" :url="regAuth"/>
            <link-component v-if="isAuthenticated" class="mt-4" title="Выход" :url="logoutUrl"/>
        </div>
    </div>
</template>

<style scoped>

</style>
