import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'
import LinkComponent from "@/components/LinkComponent.vue";
const app = createApp(App);

app.component('link-component', LinkComponent)

app.mount('#app');
