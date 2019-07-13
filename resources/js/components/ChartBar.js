import { Bar, mixins } from 'vue-chartjs'

export default {
    extends: Bar,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options'],
    mounted () {
        // Перерисовываем рендер фактическими данными
        this.renderChart(this.chartData, this.options)
    }
}