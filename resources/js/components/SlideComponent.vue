<script>
    export default {
        props : {
            open_slide: {
                type: Boolean,
                default: false
            },
            message: {
                type: Object,
            },

        },

        methods: {

        }
    }
</script>

<template>
    <div class="slide p-7">
        <div class="btn-close flex items-end justify-end">
            <button class="close-btn cursor-pointer" @click="$emit('close')">✕</button>
        </div>
        <p class="text-lg mb-4">Ответ на сообщение</p>
        <div class="head-email">
            <div class="send-email flex w-full flex-col gap-4">
                <input type="text" placeholder="От кого" class="border border-slate-100 rounded-md p-3 w-full" :value="message?.email_send">
                <input type="text" placeholder="Кому" class="border border-slate-100 rounded-md p-3 w-full">
            </div>
        </div>
        <div class="body-email mt-12 ">
            <label class="" for="message">Введите текст сообщения</label>
            <textarea class="w-full border border-slate-100 rounded-md p-3 mt-3" name="message">{{message?.message}}</textarea>
        </div>
        <button class="p-2 text-white bg-slate-400 rounded-md cursor-pointer">Отправить</button>
    </div>
</template>

<style scoped>

</style>
