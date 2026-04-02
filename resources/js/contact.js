import './bootstrap';
import { createApp } from 'vue';
import FormWidget from "./widgets/FormWidget.vue";

const form = createApp(FormWidget);

form.mount('#form');
