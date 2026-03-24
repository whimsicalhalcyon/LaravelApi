import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import axios from  'axios'

const api = axios.create({
    baseURL: 'http://restapi.local/'
})

api.get('/messages').then(response =>console.log(response.data)).catch(error => console.error(error))

const app = createApp(App)
app.config.globalProperties.$api = api
app.mount('#app')
