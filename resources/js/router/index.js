import {createRouter, createWebHistory} from 'vue-router'

import Reply from "../Reply.vue";
import App from '../App.vue'
import NewInbox from "../components/NewInbox.vue";

const routes = [
    {
        path: '/',
        name:'message',
        component: NewInbox,
        meta: {requiresAuth: true}
    },
    {
        path: '/reply',
        name:'reply',
        component: Reply,
        meta: {requiresAuth: true}
    },
]

const router = createRouter({
    history: createWebHistory(),routes
})

router.beforeEach((to, from, next) =>{
    const isAuth = window.Laravel.signedIn
})

export default router
