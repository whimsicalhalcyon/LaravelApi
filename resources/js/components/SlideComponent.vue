<script>
    export default {
        props : {
            open_slide: Boolean,
            default: false
        },

        methods: {

        }
    }
</script>

<template>
    <div class="slide p-4">
        <p>Ответ на сообщение</p>
        <div class="head-email">
            <div class="send-email flex w-full flex-col gap-4">
                <input type="text" placeholder="От кого" class="border border-slate-100 rounded-md p-3 w-full">
                <input type="text" placeholder="Кому" class="border border-slate-100 rounded-md p-3 w-full">
            </div>
        </div>
        <div class="body-email mt-12 ">
            <label class="mb-3" for="message">Введите текст сообщения</label>
            <textarea class="w-full border border-slate-100 rounded-md p-3" name="message">Тест</textarea>
        </div>
        <button class="p-2 text-white bg-slate-400 rounded-md cursor-pointer">Отправить</button>
    </div>
</template>

<style scoped>

</style>
