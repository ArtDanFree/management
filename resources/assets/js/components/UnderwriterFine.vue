<template>
    <!-- Modal Изменение процента комиссии -->
    <div class="modal fade" id="modal-underwriter-fine" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ранг</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="errors.length" class="container">
                        <div class="alert alert-danger">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                    <form>
                        <div class="form-group">
                            <input v-model="form.level" type="number" class="form-control" required>
                        </div>
                    </form>
                    <button @click="change" class="btn btn-warning btn-lg btn-block">Изменить</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Изменение процента комиссии  -->
</template>
<script>
    export default {
        name: "UnderwriterFine",
        props: ['user_id'],
        data: function () {
            return {
                errors: [],
                form: {
                    level: null
                },
            }
        },
        methods: {
            checkForm(e){
                this.errors = [];
                if (this.form.level < 0 ) {
                    this.errors.push('Ранг не может быть меньше 0');
                }else if (this.form.level > 15) {
                    this.errors.push('Ранг не может быть больше 15 ');
                }
                if (!this.errors.length) {
                    return true;
                }
                e.preventDefault();
            },
            formSubmit() {
                let vm = this;
                axios.post('/admin/ajax/user_fine_update/' + vm.user_id, vm.form)
                    .then(function (rest) {
                        location.reload()
                    })
                    .catch(function (resp) {

                    });
            },

            change() {
                if (this.checkForm()) {
                    this.formSubmit();
                }
            }
        }
    }
</script>

<style scoped>

</style>