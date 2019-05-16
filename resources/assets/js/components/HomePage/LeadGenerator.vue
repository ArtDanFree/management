<template>
    <div>
        <h1><b>Список отправленных лидов</b></h1>
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
                    <th class="d-none d-md-table-cell" scope="col">Тип</th>
                    <th scope="col">Дата</th>
                    <th class="d-none d-md-table-cell" scope="col">Город</th>
                    <th scope="col">Сумма</th>
                    <th class="d-none d-md-table-cell" scope="col">Выданная сумма</th>
                    <th scope="col">ФИО</th>
                    <th class="d-none d-md-table-cell" scope="col">Проверка</th>
                    <th class="d-none d-md-table-cell" scope="col">Выдача</th>
                </tr>
                </thead>
                <tbody id='n'>
                <tr class="no-color-tr tr" v-for="lead in data.data" @click="showLead(lead.id)" v-bind:class="trClass(lead)">
                    <td class="d-none d-md-table-cell" v-if="lead.type_deposit.name == 'Недвижимость'"><img class="type" src="img/home.svg"></td>
                    <td class="d-none d-md-table-cell" v-else><img class="type" src="img/car.svg"></td>
                    <td >{{ lead.timezone }}</td>
                    <td class="d-none d-md-table-cell">{{ lead.city.name }}</td>
                    <td>{{ lead.money }}</td>
                    <td class="d-none d-md-table-cell">{{ lead.total_amount ? lead.total_amount : 'Пусто' }}</td>
                    <td v-if="lead.first_name == null && lead.last_name == null && lead.surname == null">Нет данных</td>
                    <td v-else>{{ lead.first_name + ' ' + lead.last_name + ' ' + lead.surname }}</td>
                    <td class="d-none d-md-table-cell">{{ lead.status.name }}</td>
                    <td class="d-none d-md-table-cell">{{ lead.transaction_status ? lead.transaction_status.name : 'Пусто' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="data" v-on:count="changeCount" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
    export default {
        name: "LeadGenerator",
        data() {
            return {
                data: {},
                params: {
                    count: 15,
                    leads: 'all',
                    from: null,
                    to: null,
                }
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
            showLead(id) {
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
            }
        },
    }
</script>