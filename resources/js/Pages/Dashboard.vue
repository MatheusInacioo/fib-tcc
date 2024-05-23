<template>
    <BaseLayout>
        <div class="w-full web:min-h-64 rounded-xl shadow-xl flex flex-col justify-between 2xl:p-4 p-2 border border-gray-200 mb-4 mobile:h-full mobile:justify-start">
            <div class="flex justify-between items-center mobile:hidden">
                <span class="text-2xl font-medium">Resumo do dia</span>
                <span class="text-lg font-medium text-gray-500">Registros das últimas 24h</span>
            </div>

            <span class="text-2xl mb-4 font-medium web:hidden">Resumo do dia (24h)</span>

            <div class="w-full flex justify-between mobile:flex-col">
                <div class="flex flex-col justify-between mb-14 mobile:mb-4">
                    <span class="text-2xl font-medium mb-2">Faturamento</span>
                    <span class="text-xl text-gray-500">R$ 0.00</span>
                </div>
                <div class="flex flex-col justify-between mb-14 mobile:mb-4">
                    <span class="text-2xl font-medium mb-2">Título</span>
                    <span class="text-xl text-gray-500">R$ 0.00</span>
                </div>
                <div class="flex flex-col justify-between mb-14 mobile:mb-4">
                    <span class="text-2xl font-medium mb-2">Título</span>
                    <span class="text-xl text-gray-500">R$ 0.00</span>
                </div>
                <div class="flex flex-col justify-between mb-14 mobile:mb-4">
                    <span class="text-2xl font-medium mb-2">Título</span>
                    <span class="text-xl text-gray-500">R$ 0.00</span>
                </div>
                <div class="flex flex-col justify-between mb-14 mobile:mb-4">
                    <span class="text-2xl font-medium mb-2">Título</span>
                    <span class="text-xl text-gray-500">R$ 0.00</span>
                </div>
            </div>
        </div>
        
        <div class="w-full h-full rounded-xl flex flex-col justify-between shadow-xl 2xl:p-4 p-2 border border-gray-200 mb-4">
            <p class="font-medium 2xl:text-2xl text-xl">Entradas</p>

            <canvas class="max-h-[95%]" id="entryChart"></canvas>
        </div>

        <div class="w-full h-full flex mobile:flex-col">
            <div class="flex flex-col justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile:min-h-[500px] w-full border border-gray-200 mr-4 mobile:mb-4">
                <p class="font-medium 2xl:text-2xl text-xl">Estoque</p>

                <canvas class="web:max-h-[95%]" id="stockChart"></canvas>
            </div>
            <div class="flex flex-col justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile:min-h-[500px] w-full border border-gray-200">
                <p class="font-medium 2xl:text-2xl text-xl">Saídas</p>

                <canvas class="web:max-h-[95%]" id="exitChart"></canvas>
           </div>
        </div>
    </BaseLayout>
</template>

<script>
    import Chart from 'chart.js/auto';
    import BaseLayout from '@/Components/Layout/BaseLayout.vue'; 

    export default {
        components: {
            BaseLayout,
        },

        data() {
            return {
                entryChartSettings: {
                    type: 'bar',
                    name: 'Entradas',
                    labels: [
                        'Janeiro',
                        'Fevereiro',
                        'Março',
                        'Abril',
                        'Maio',
                        'Junho',
                        'Julho',
                        'Agosto',
                        'Setembro',
                        'Outubro',
                        'Novembro',
                        'Dezembro'
                    ],
                    data: [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24],
                },

                exitChartSettings: {
                    type: 'line',
                    name: 'Saídas',
                    labels: [
                        'Janeiro',
                        'Fevereiro',
                        'Março',
                        'Abril',
                        'Maio',
                        'Junho',
                        'Julho',
                        'Agosto',
                        'Setembro',
                        'Outubro',
                        'Novembro',
                        'Dezembro'
                    ],
                    data: [23, 21, 19, 17, 15, 13, 11, 9, 7, 5, 3, 1],
                },

                stockChartSettings: {
                    type: 'bar',
                    name: 'Estoque',
                    labels: [
                        'Janeiro',
                        'Fevereiro',
                        'Março',
                        'Abril',
                        'Maio',
                        'Junho',
                        'Julho',
                        'Agosto',
                        'Setembro',
                        'Outubro',
                        'Novembro',
                        'Dezembro'
                    ],
                    data: [23, 21, 19, 17, 15, 13, 11, 9, 7, 5, 3, 1],
                },
            }
        },

        methods: {
            buildChart(ctx, chart) {
                new Chart(ctx, {
                    type: chart.type,
                    data: {
                        labels: chart.labels,
                        datasets: [{
                            label: chart.name,
                            data: chart.data,
                            borderWidth: 1,
                            maxBarThickness: 30,
                            aspectRatio: 0.8,
                            borderRadius: {
                                topRight: 15,
                                topLeft: 15
                            }
                        }]
                    },
                    options: {
                        indexAxis: window.innerWidth <= 800 ? 'y' : 'x',
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        },

        mounted() {
            const entryChart = document.getElementById('entryChart');
            const exitChart = document.getElementById('exitChart');
            const stockChart = document.getElementById('stockChart');

            this.buildChart(entryChart, this.entryChartSettings);
            this.buildChart(exitChart, this.exitChartSettings);
            this.buildChart(stockChart, this.stockChartSettings);
        }
    }
</script>
