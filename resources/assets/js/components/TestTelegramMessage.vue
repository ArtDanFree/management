<template>
    <div class="text-center telegram-test">
        <button @click="send" class="btn btn-link">Отправить тестовое сообщение в телеграм</button>
    </div>
</template>

<script>
    export default {
        name: "TestTelegramMessage",
        methods: {
            send: () => {
                axios.get('/sendTestMessageToTelegram')
                    .then(function (response) {
                        Swal.fire({
                            type: 'success',
                            text: response.data.message,
                        })
                    })
                    .catch(function (error) {
                        Swal.fire({
                            type: 'error',
                            text: error.response.data.message,
                        })
                    });
            }
        }
    }
</script>

<style scoped>
.telegram-test button {
    font-size: 18px!important;
}
</style>