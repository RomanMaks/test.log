<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <chart-bar
                        :chart-data="dataBar"
                        :heigth="50"
                        :options="{responsive: true, maintainAspectRatio: true}">
                </chart-bar>
            </div>
            <div class="col-sm-6">
                <chart-bar
                        :chart-data="dataBar"
                        :heigth="50"
                        :options="{responsive: true, maintainAspectRatio: true}">
                </chart-bar>
            </div>
        </div>
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
    import ChartBar from './ChartBar.js'

    const horizonalLinePlugin = {
        id: 'horizontalLine',
        afterDraw: function(chartInstance) {

            var yValue;
            var yScale = chartInstance.scales["y-axis-0"];
            var canvas = chartInstance.chart;
            var ctx = canvas.ctx;
            var index;
            var line;
            var style;

            if (chartInstance.options.horizontalLine) {

                for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                    line = chartInstance.options.horizontalLine[index];

                    if (!line.style) {
                        style = "#080808";
                    } else {
                        style = line.style;
                    }

                    if (line.y) {
                        yValue = yScale.getPixelForValue(line.y);
                    } else {
                        yValue = 0;
                    }
                    ctx.lineWidth = 3;

                    if (yValue) {
                        window.chart = chartInstance;
                        ctx.beginPath();
                        ctx.moveTo(0, yValue);
                        ctx.lineTo(canvas.width, yValue);
                        ctx.strokeStyle = style;
                        ctx.stroke();
                    }

                    if (line.text) {
                        ctx.fillStyle = style;
                        ctx.fillText(line.text, 0, yValue + ctx.lineWidth);
                    }
                }
                return;
            }
        }
    };

    export default {
        name: "DashboardComponent",
        components: {
            ChartBar
        },
        data() {
            return {
                date: null,
                os: null,
                architecture: null,
                dataBar: [],
                dataBarStacked: [],
                logs: [],
                listOs: [],
            }
        },
        methods: {
            reset() {
                this.date = null;
                this.os = null;
                this.architecture = null;
                this.requestsPerDay = null;
                this.fetch();
            },
            fetch() {
                axios.get(`/api/v1/dashboard/table`, {
                    params: {
                        date: this.date,
                        os: this.os,
                        architecture: this.architecture,
                    }
                }).then(response => {
                    this.logs = response.data.logs;
                    this.listOs = response.data.os;
                });

                this.updateChartBar();
            },
            updateChartBar() {
                axios.get(`/api/v1/dashboard/chart-bar`, {
                    params: {
                        date: this.date,
                        os: this.os,
                        architecture: this.architecture,
                    }
                }).then(response => {
                    this.dataBar = response.data;
                })
            },
            updateChartBarStacked() {
                axios.get(`/api/v1/dashboard/chart-bar-stacked`, {
                    params: {
                        date: this.date,
                        os: this.os,
                        architecture: this.architecture,
                    }
                }).then(response => {
                    this.dataBarStacked = response.data;
                })
            },
        },
        mounted() {
            this.fetch();
        }
    }
</script>
