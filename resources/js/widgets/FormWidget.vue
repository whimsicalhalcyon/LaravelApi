<script>
export default {
    data() {
        return {
            form: {
                title: '',
                email_send: '',
                message: '',
                category_id: ''
            },
            success: false,
            error: ''
        }
    },
    methods: {
        async sendForm() {
            this.success = false;
            this.error = '';

            try {
                const res = await fetch('http://restapi.local/api/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });

                if (!res.ok) {
                    const text = await res.text();
                    throw new Error(text || 'Ошибка при отправке');
                }

                const data = await res.json();
                console.log('Успешно отправлено:', data);

                this.success = true;

                this.form = { title: '', email_send: '', message: '', category_id: 1 };


            } catch (e) {
                console.error(e);
                this.error = 'Ошибка отправки: ' + e.message;
            }
        }
    }
}
</script>

<template>
    <div class="form-container">
        <h1>Отправить новое сообщение</h1>

        <form @submit.prevent="sendForm">
            <input
                type="text"
                v-model="form.title"
                placeholder="Заголовок"
                required
            />

            <select v-model="form.category_id">
                <option value="">Выберите категорию</option>
                <option value="1">Сообщить об ошибке</option>
                <option value="2">Обращение</option>
                <option value="3">Предложение</option>
            </select>

            <input
                type="email"
                v-model="form.email_send"
                placeholder="Ваш Email"
                required
            />

            <textarea
                v-model="form.message"
                placeholder="Сообщение"
                rows="6"
                required
            ></textarea>

            <button type="submit">Отправить сообщение</button>
        </form>
        <p v-if="error" class="error">{{ error }}</p>
    </div>
</template>

<style scoped>
.form-container {
    display: flex;
    flex-direction: column;
}

form {
    display: flex;
    flex-direction: column;
    gap:15px;
}

input, textarea, select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px
}

button {
    background-color: rgb(0, 78, 166);
    width: 200px;
    padding: 15px 10px;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 10px;

}
</style>
