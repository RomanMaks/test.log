import { Bar, mixins } from 'vue-chartjs'

export default {
    extends: Bar,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options'],
    mounted () {
        // Перерисовываем рендер фактическими данными
        this.renderChart(this.chartData, this.options)
        // this.renderChart({
        //     // Здесь указываем день
        //     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        //     datasets: [
        //         {
        //             label: 'Число запросов',
        //             backgroundColor: '#f87979',
        //
        //             // Здесь указывае кол-во запросов для каждлго дня
        //             data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
        //         }
        //     ]
        // })
    }
}