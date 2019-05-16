<template>
    <div>
        <h1><b>Список лидов</b></h1>
        <form class="form-inline form-filter">
            <div class="form-group">
                <select v-model="params.leads" class="custom-select" id='effectTypes'>
                    <option value="all">Все лиды</option>
                    <option value="free">Свободные лиды</option>
                    <option value="unclaimed">Невостребованные</option>
                    <option value="bad-quality">Некачественные</option>
                </select>
            </div>
            <div class="form-group">
                <label class="label-filter">С</label>
                <input v-model="params.from" class="form-control" type="date">
            </div>
            <div class="form-group">
                <label class="label-filter">По</label>
                <input v-model="params.to" class="form-control" type="date">
            </div>
        </form>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead class="bg-success">
                <tr>
                    <th class="d-none d-md-table-cell" >Тип</th>
                    <th >Дата</th>
                    <th class="d-none d-md-table-cell" >Лидогенератор</th>
                    <th >Частный инвестор</th>
                    <th >Город</th>
                    <th >Сумма</th>
                    <th >ФИО</th>
                    <th class="d-none d-md-table-cell" >Проверка</th>
                    <th class="d-none d-md-table-cell" >Выдача</th>
                </tr>
                </thead>
                <tbody id='n'>
                <tr class="no-color-tr tr" v-for="lead in data.data"  v-bind:class="trClass(lead)">
                    <td @click="show(lead.id)" class="d-none d-md-table-cell" v-if="lead.type_deposit.name == 'Недвижимость'"><img class="type" src="img/home.svg"></td>
                    <td @click="show(lead.id)" class="d-none d-md-table-cell" v-else><img class="type" src="img/car.svg"></td>
                    
                    <td @click="show(lead.id)" >{{ lead.timezone }}</td>
                    
                    <td @click="showLeadGenerator(lead.user.id)" v-if="lead.user.first_name == null" class="d-none d-md-table-cell">
                        Нет данных
                    </td>
                    <td @click="showLeadGenerator(lead.user.id)" v-else class="d-none d-md-table-cell"><button type="button" class="btn btn-link">{{ lead.user.first_name }}</button></td>
                    
                    <td v-if="lead.underwriter == null">
                        <button @click="openModal(lead)" type="button" class="btn btn-link" data-toggle="modal" data-target="#modal-assign-lead">Назначить</button>
                    </td>
                    <td v-else>
                        <button @click="showChin(lead.underwriter.id)" class="btn btn-link">{{ lead.underwriter.last_name}}<br>{{ lead.underwriter.first_name }}<br>{{ lead.underwriter.surname }}</button>
                    </td>
                    <td @click="show(lead.id)" v-bind:class="{ 'color-red': lead.city.underwriter.length == 0 }">{{ lead.city.name }}</td>
                    
                    <td @click="show(lead.id)">{{ lead.money }}</td>
                    
                    <td @click="show(lead.id)" v-if="lead.first_name == null && lead.last_name == null && lead.surname == null">Нет данных</td>
                    <td @click="show(lead.id)" v-else>{{ lead.first_name + ' ' + lead.last_name + ' ' + lead.surname }}</td>
                    
                    <td @click="show(lead.id)" class="d-none d-md-table-cell">{{lead.status.name}}</td>
                    <td @click="show(lead.id)" class="d-none d-md-table-cell">{{ lead.transaction_status ? lead.transaction_status.name : 'Пусто' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="data" v-on:count="changeCount" @pagination-change-page="getResults"></pagination>
        <assign-underwriter :lead="modalLead"></assign-underwriter>
    </div>
</template>
<script>
    export default {
        name: "Admin",
        data() {
            return {
                data: {},
                modalLead: {}
                ,
                params: {
                    count: 15,
                    leads: 'all',
                    from: null,
                    to: null,
                },
            }
        },
        mounted() {
            this.getResults();
        },
        watch: {
            params: {
                handler() {
                    this.getResults();
                },
                deep: true,
            }},
        methods: {
            openModal(lead){
                this.modalLead = lead;
            },
            showLeadGenerator(id) {
                location = '/admin/user/'+ id +'/leads'
            },
            show(id) {
                location = '/lead/' + id
            },
            changeCount(count){
                this.params.count = count;
                this.getResults();
            },
            getResults(page = 1) {
                axios.get('/ajax/home_page?page=' + page, {
                    params: this.params
                })
                    .then(response => {
                        this.data = response.data;
                    });
            },
            trClass: function (lead) {
                if (lead.transaction_status.name == 'Сделка заключена' && lead.status.name == 'Сделка') {
                    return 'table-success'
                } else if (lead.transaction_status.name == 'Сделка не заключена' && lead.status.name == 'Некачественный лид') {
                    return 'table-danger'
                }
            },
            showChin: function (id) {
                location = '/report/underwriter_report_taken_on_check_leads/' + id
            }
        },
    }
</script>
<style scoped>
button {
    font-size: 1rem !important;
}
</style>