import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'
import LinkComponent from "@/components/LinkComponent.vue";
import router from './router';
const app = createApp(App);

app.component('link-component', LinkComponent)
app.use(router)

app.mount('#app');
