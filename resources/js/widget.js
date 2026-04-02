import './bootstrap';
import { createApp } from 'vue';
import Widget from "./Widget.vue";

const widget = createApp(Widget);

widget.mount('#widget');
