<template>
    <div>
        <div v-if="lead" class="modal fade" id="take-on-check" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Взять лида на проверку</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <ul class="ul list-group">
                                Имя
                                <li class="list-group-item">{{ lead.first_name }}</li>
                                Фамилия
                                <li class="list-group-item">{{ lead.last_name }}</li>
                                Отчество
                                <li class="list-group-item">{{ lead.surname }}</li>
                                Желаемая сумма:
                                <li class="list-group-item">{{ lead.money }}</li>
                            </ul>
                        </div>
                        <button @click="takeOnCheck(lead.id)" class="btn btn-success btn-lg btn-block">Взять на проверку</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TakeOnCheck",
        props: ['lead_id'],
        data(){
            return {
                message: '',
                lead: {}
            }
        },
        created() {
            if (urlParams.get('lead_id')) {
                this.getLead(urlParams.get('lead_id'))
            }
        },
        watch: {
            lead_id: function (lead_id) {
                this.getLead(lead_id)
            },
        },
        methods: {
            takeOnCheck(id) {
                axios.put('ajax/lead/take_on_check', {
                    lead_id: id
                })
                    .then(response => {
                        if (response.data.url) {
                            console.log(response.data.url);
                            location = response.data.url;
                        }
                        if (response.data.message) {
                            alert(response.data.message)
                        }
                    })
                    .catch(response => {
                        alert('Произошла ошибкаа')
                    })
            },
            getLead: function (id) {
                axios.get('ajax/lead/get/', {
                    params: {
                        lead_id: id
                    }
                })
                    .then(response => {
                        if (response.data.message) {
                            Swal.fire({
                                type: 'error',
                                text: response.data.message,
                            })
                        }
                        if (response.data.lead) {
                            this.lead = response.data.lead;
                            $('#take-on-check').modal('toggle')
                        }
                    });
            }
        }
    }
</script>

<style scoped>

</style>