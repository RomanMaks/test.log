<template>
    <div>
        <div class="alert alert-dark collapse show" role="alert" id="collapseExample">
            <form>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="date">Дата</label>
                        <input v-model="date" type="date" class="form-control" id="date">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="os">ОС</label>
                        <select v-model="os" class="form-control select2-container" id="os">
                            <option></option>
                            <option v-for="value in listOs" :value="value">{{ value }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="architecture">Архитектура</label>
                        <select v-model="architecture" class="form-control select2-container" id="architecture">
                            <option></option>
                            <option value="x86">x86</option>
                            <option value="x64">x64</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <button type="submit" @click.prevent="fetch" class="btn btn-outline-secondary">
                        <i class="fas fa-filter"></i> Фильтровать
                    </button>

                    <button type="submit" @click.prevent="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-filter"></i> Сбросить фильтры
                    </button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Дата запроса</th>
                        <td>Число запросов</td>
                        <th>Url</th>
                        <th>Браузер</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="log in logs">
                        <td>{{ log.date }}</td>
                        <td>{{ log.count }}</td>
                        <td>{{ log.url }}</td>
                        <td>{{ log.browser }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DashboardComponent",
        data() {
            return {
                date: null,
                os: null,
                architecture: null,
                logs: [],
                listOs: [],
            }
        },
        methods: {
            reset() {
                this.date = null;
                this.os = null;
                this.architecture = null;
                this.fetch();
        },
            fetch() {
                axios.get(`/`, {
                    params: {
                        date: this.date,
                        os: this.os,
                        architecture: this.architecture,
                    }
                }).then(response => {
                    this.logs = response.data.logs;
                    this.listOs = response.data.os;
                })
            }
        },
        mounted() {
            this.fetch();
        }
    }
</script>
