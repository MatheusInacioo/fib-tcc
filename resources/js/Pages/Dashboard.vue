<template>
    <BaseLayout>
        <span class="text-2xl font-medium">Resumo do dia</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div class="flex mobile-std:flex-col mobile-std:items-center web:mb-4 mobile-lg:justify-evenly">
            <div class="web:flex web:w-[50%] web:justify-evenly mobile-lg:flex-col mobile-lg:justify-between">
                <div class="info-card w-[350px] min-h-52 mobile-std:w-[320px] mobile-std:min-h-48 rounded-xl shadow-xl flex flex-col border border-gray-200 mobile-std:mb-4 mobile-lg:mb-4 web:mr-8 transition-all hover:scale-105">
                    <div class="flex justify-between items-center h-[33%] bg-green-500 rounded-t-xl p-4">
                        <span class="text-2xl mobile-std:text-xl font-medium mb-2 text-white">Faturamento</span>
                        <i class="bx bx-dollar text-white text-3xl mobile-std:text-2xl"></i>
                    </div>

                    <div class="h-full p-4 flex flex-col justify-between">
                        <span class="text-2xl mobile-std:text-xl font-medium mb-2 text-black">R$0,00</span>
                        <div class="text-lg mobile-std:text-sm font-medium text-green-500">+ 0.00% em relação ao dia anterior</div>
                    </div>
                </div>

                <div class="info-card w-[350px] min-h-52 mobile-std:w-[320px] mobile-std:min-h-48 rounded-xl shadow-xl flex flex-col border border-gray-200 mobile-std:mb-4 mobile-lg:mb-4 web:mr-8 transition-all hover:scale-105">
                    <div class="flex justify-between items-center h-[33%] bg-blue-500 rounded-t-xl p-4">
                        <span class="text-2xl mobile-std:text-xl font-medium mb-2 text-white">Visão Geral</span>
                        <i class="bx bx-package text-white text-3xl mobile-std:text-2xl"></i>
                    </div>

                    <div class="h-full p-4 flex flex-col justify-between">
                        <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">0 entradas</span>
                        <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">0 saídas</span>
                        <div class="text-lg mobile-std:text-sm font-medium text-green-500">+ 0.00% em relação ao dia anterior</div>
                    </div>
                </div>
            </div>

            <div class="web:flex web:w-[50%] mobile-lg:flex-col mobile-lg:justify-between">
                <div class="info-card w-[350px] min-h-52 mobile-std:w-[320px] mobile-std:min-h-48 rounded-xl shadow-xl flex flex-col border border-gray-200 mobile-std:mb-4 mobile-lg:mb-4 web:mr-8 transition-all hover:scale-105">
                    <div class="flex justify-between items-center h-[33%] bg-yellow-500 rounded-t-xl p-4">
                        <span class="text-2xl mobile-std:text-xl font-medium mb-2 text-white">Notificações</span>
                        <i class="bx bx-info-circle text-white text-3xl mobile-std:text-2xl"></i>
                    </div>

                    <div class="h-full p-4 flex flex-col justify-between">
                        <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">0 pedidos agendados para hoje</span>
                    </div>
                </div>

                <div class="info-card w-[350px] min-h-52 mobile-std:w-[320px] mobile-std:min-h-48 rounded-xl shadow-xl flex flex-col border border-gray-200 mobile-std:mb-4 mobile-lg:mb-4 web:mr-8 transition-all hover:scale-105">
                    <div class="flex justify-between items-center h-[33%] bg-red-500 rounded-t-xl p-4">
                        <span class="text-2xl mobile-std:text-xl font-medium mb-2 text-white">Alertas</span>
                        <i class="bx bx-error text-white text-3xl mobile-std:text-2xl"></i>
                    </div>

                    <div class="h-full p-4 flex flex-col justify-between">
                        <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">0 produtos com baixa quantidade em estoque</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full rounded-xl shadow-lg mb-4 border border-gray-200">
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:max-h-[400px] mobile-std:min-h-[500px] w-full border border-gray-200 mobile-std:mb-4">
                <p class="font-medium 2xl:text-2xl text-xl">Faturamento</p>

                <canvas class="web:max-h-[85%]" id="stockChart"></canvas>
            </div>
        </div>

        <div class="flex mobile-std:flex-col w-full">
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile-std:min-h-[500px] w-[50%] mobile-std:w-full max-w-full border border-gray-200 mr-4 mobile-std:mb-4">
                <p class="font-medium 2xl:text-2xl text-xl">Entradas</p>

                <canvas class="web:max-h-[95%]" id="entryChart"></canvas>
            </div>
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile-std:min-h-[500px] w-[50%] mobile-std:w-full max-w-full border border-gray-200">
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
                    axis: window.innerWidth <= 1024 ? 'y' : 'x',
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
                    axis: window.innerWidth <= 1024 ? 'y' : 'x',
                    type: 'bar',
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
                    axis: window.innerWidth <= 800 ? 'y' : 'x',
                    type: 'line',
                    name: 'Faturamento',
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
                    data: [13, 21, 22, 14, 15, 23, 11, 9, 18, 5, 3, 2],
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
                            maxBarThickness: window.innerWidth <= 1024 ? 15 : 20,
                            aspectRatio: 0.8,
                            tension: 0.1,
                            borderRadius: {
                                topRight: 15,
                                topLeft: 15
                            },
                            animation: {
                              duration: 500
                            },
                        }]
                    },
                    options: {
                        indexAxis: chart.axis,
                        responsive: true,
                        aspectRatio: window.innerWidth <= 1024 ? 0.8 : 2,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        elements: {
                            bar: {
                              borderRadius: {
                                topRight: 15,
                                bottomRight: window.innerWidth <= 1024 ? 15 : 0,
                                topLeft: window.innerWidth <= 1024 ? 0 : 15,
                              }
                            }
                        },
                    },
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
