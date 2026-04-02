import './bootstrap';
import { createApp } from 'vue';
import Cors from "./Cors.vue";

const cors = createApp(Cors);

cors.mount('#cors');
