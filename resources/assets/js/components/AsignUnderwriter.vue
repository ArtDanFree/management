<template>
    <div class="modal fade" id="modal-assign-lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
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
                    <form>
                        <div class="form-group">
                            <label>Частные инверторы<span class="color-red">*</span></label>
                            <select v-model="form.underwriter_id" id="underwrites" class="custom-select form-control-lg chosen-select">
                                <option v-for="underwriter in underwriters" v-bind:value="underwriter.id">
                                    {{ underwriter.first_name }} {{ underwriter.last_name }} {{ underwriter.surname }}
                                </option>
                            </select>
                        </div>
                    </form>
                    <button v-on:click="assignUnderwriter()" class="btn btn-success btn-lg btn-block">Назначить</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['lead'],
        data: function () {
            return {
                underwriters: [],
                form: {
                    underwriter_id: '',
                },
                
            }
        },
        watch: {
            lead: function () {
                this.getUnderwrites();
            }
        },
        methods: {
            getUnderwrites() {
                if (this.lead.city.underwriter.length == 0) {
                    this.getAllUnderwrites();
                } else {
                    this.getUnderwritersInCity()
                }

            },
            getAllUnderwrites(){
                let vm = this;
                axios.get('/assign_underwriters/')
                    .then(function (resp) {
                        vm.underwriters = resp.data;
                    })
                    .catch(function (resp) {
                        alert("Не удалось загрузить частных инвесторов");
                    });
            },
            getUnderwritersInCity() {
                let vm = this;
                axios.get('/assign_underwriters/' + vm.lead.city.name)
                    .then(function (resp) {
                        vm.underwriters = resp.data;
                    })
                    .catch(function (resp) {
                        alert("Не удалось загрузить частных инвесторов");
                    });
            },
            assignUnderwriter() {
                let app = this;
                let assign = app.form;
                axios.post('assign_underwriters/' + app.lead.id, assign)
                    .then(function () {
                        console.log(
                            window.location.reload()
                        );
                        
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось");
                    });
            }
        }
    }

</script>

<style scoped>

</style>
