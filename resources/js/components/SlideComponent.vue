<script>
    import InputComponent from "@/components/InputComponent.vue";

    export default {
        components: {InputComponent},
        props : {
            open_slide: {
                type: Boolean,
                default: false
            },
            message: {
                type: Object,
            },

        },
        data() {
            return {
                email_reply: this.message?.email_send || '',
                title: '',
                reply: '',
                user_id:1,
                message_id: this.message?.id || '',
            }
        },

        methods: {
            async deleteMessage() {
                if (!this.message?.id) return;

                try {
                    const res = await fetch(`http://restapi.local/api/messages/${this.message.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });

                    if (!res.ok) throw new Error('Не удалось удалить сообщение');

                    this.$emit('deleted', this.message.id);
                    this.$emit('close');
                } catch (error) {
                    console.error(error);
                    alert('Ошибка при удалении сообщения');
                }
            },
            async postReply() {
                if (!this.message?.id || !this.reply) return

                const replyData = {
                    title: this.title,
                    message: this.reply,
                    email_reply: this.email_reply,
                    message_id: this.message_id,
                    user_id: this.user_id
                }

                try {
                    const res = await fetch('http://restapi.local/api/replies', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(replyData)
                    })

                    if (!res.ok) {
                        throw new Error('Ошибка сервера: ' + res.statusText);
                    }

                    const result = await res.json()
                    console.log('Ответ сервера', result)

                    this.$emit('reply-sent', result)
                    this.title = '';
                    this.reply = '';
                } catch (error) {
                    console.log(error)
                }
            }
        }
    }
</script>

<template>
    <div class="slide p-7">
        <div class="btn-close flex items-end justify-end">
            <button class="close-btn cursor-pointer" @click="$emit('close')">✕</button>
        </div>

        <form  @submit.prevent="postReply">
            <p class="text-lg mb-4">Ответ на сообщение</p>
            <div class="head-email">
                <div class="send-email flex w-full flex-col gap-4">
                    <input type="text" placeholder="Кому" class="border border-slate-100 rounded-md p-3 w-full" :value="message?.email_send"></div>
            </div>
            <div class="user-mail mt-5">
                <label class="" for="message">Текст сообщения</label>
                <div class="user-message bg-slate-100 p-2 rounded-md">
                    {{message?.message}}
                </div>
            </div>
            <div class="body-email mt-12 ">
                <label class="" for="message">Введите текст сообщения</label>
                <input type="text" v-model="title" placeholder="Текст ответа" class="border border-slate-100 rounded-md p-3 w-full">
                <textarea class="w-full border border-slate-100 rounded-md p-3 mt-3" name="message" v-model="reply"></textarea>
            </div>
            <button class="p-2 text-white bg-slate-400 rounded-md cursor-pointer" type="submit">Отправить</button>
        </form>
        <button class="p-2 text-white bg-red-500 rounded-md cursor-pointer mt-4" @click="deleteMessage">Удалить</button>
    </div>
</template>

<style scoped>

</style>
