<template>
    <BaseLayout>
        <Head title="Dashboard"/>
        <span class="text-2xl font-medium">Resumo do dia</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div class="grid grid-cols-4 gap-4 mobile-std:grid-cols-1 mobile-lg:grid-cols-2 mb-4">
            <div class="info-card h-52 rounded-xl shadow-xl flex flex-col border border-gray-200 transition-all hover:scale-105">
                <div class="flex justify-between items-center h-[33%] bg-green-500 rounded-t-xl p-4">
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Faturamento</span>
                    <i class="bx bx-dollar text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div
                    v-if="dayStats.invoicing"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span class="text-2xl mobile-std:text-xl font-medium text-black">{{ dayStats.invoicing.total }}</span>
                    <div class="web:text-lg text-sm font-medium text-green-500">{{ dayStats.invoicing.change + ' em relação ao dia anterior' }} </div>
                </div>

                <div
                    v-else
                    class="h-full p-4 flex justify-center items-center"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">Nenhuma transação registrada na data atual. Aguardando novos dados...</span>
                </div>
            </div>

            <div class="info-card h-52 rounded-xl shadow-xl flex flex-col border border-gray-200 transition-all hover:scale-105">
                <div class="flex justify-between items-center h-[33%] bg-blue-500 rounded-t-xl p-4">
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Visão Geral</span>
                    <i class="bx bx-bar-chart text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div
                    v-if="dayStats.entries > 0 || dayStats.outputs > 0"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">{{ dayStats.entries + ' entradas' }}</span>
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">{{ dayStats.outputs + ' saídas' }}</span>
                    <div class="web:text-lg text-sm font-medium text-green-500">+ 0.00% em relação ao dia anterior</div>
                </div>

                <div
                    v-else
                    class="h-full p-4 flex justify-center items-center"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">Nenhuma transação registrada na data atual. Aguardando novos dados...</span>
                </div>
            </div>
            <div class="info-card h-52 rounded-xl shadow-xl flex flex-col border border-gray-200 transition-all hover:scale-105">
                <div class="flex justify-between items-center h-[33%] bg-yellow-500 rounded-t-xl p-4">
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Notificações</span>
                    <i class="bx bx-info-circle text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div class="h-full p-4 flex flex-col justify-between">
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">0 pedidos agendados para hoje</span>
                </div>
            </div>

            <div class="info-card h-52 rounded-xl shadow-xl flex flex-col border border-gray-200 transition-all hover:scale-105">
                <div class="flex justify-between items-center h-[33%] bg-red-500 rounded-t-xl p-4">
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Alertas</span>
                    <i class="bx bx-error text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div
                    v-if="dayStats.low_products > 0"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">{{ dayStats.low_products + ' produtos com baixa quantidade em estoque'}}</span>
                </div>

                <div
                    v-else
                    class="h-full p-4 flex justify-center items-center"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">Nenhum alerta iminente. Tudo certo!</span>
                </div>
            </div>
        </div>

        <div class="w-full rounded-xl shadow-lg mb-4 border border-gray-200">
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:max-h-[400px] mobile-std:min-h-[500px] w-full border border-gray-200 mobile-std:mb-4">
                <div class="flex justify-between">
                    <p class="font-medium 2xl:text-2xl text-xl">Faturamento</p>

                    <div class="relative">
                        <button
                            @click="toggleDropdown('invoicing')"
                            class="flex justify-center items-center p-2 h-10 mobile-std:min-w-16 min-w-32 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-calendar font-semibold mr-2 text-secondary"></i>
                            <p class="font-medium text-secondary mobile-std:hidden">Período</p>
                            <i class="bx bx-chevron-down font-semibold ml-2 mobile-std:ml-0 text-secondary"></i>
                        </button>

                        <div v-if="dropdowns.invoicing" class="absolute right-0 w-48 bg-white border rounded shadow-xl">
                            <a href="#" @click.prevent="filterChart('invoicing', 7)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 7 dias</a>
                            <a href="#" @click.prevent="filterChart('invoicing', 10)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 10 dias</a>
                            <a href="#" @click.prevent="filterChart('invoicing', 30)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 30 dias</a>
                        </div>
                    </div>
                </div>

                <canvas class="web:max-h-[85%]" id="invoicingChart"></canvas>
            </div>
        </div>

        <div class="flex mobile-std:flex-col w-full">
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile-std:min-h-[500px] w-[50%] mobile-std:w-full max-w-full border border-gray-200 mr-4 mobile-std:mb-4">
                <div class="flex justify-between">
                    <p class="font-medium 2xl:text-2xl text-xl">Entradas</p>

                    <div class="relative">
                        <button
                            @click="toggleDropdown('entries')"
                            class="flex justify-center items-center p-2 h-10 mobile-std:min-w-16 min-w-32 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-calendar font-semibold mr-2 text-secondary"></i>
                            <p class="font-medium text-secondary mobile-std:hidden">Período</p>
                            <i class="bx bx-chevron-down font-semibold ml-2 mobile-std:ml-0 text-secondary"></i>
                        </button>

                        <div v-if="dropdowns.entries" class="absolute right-0 w-48 bg-white border rounded shadow-xl">
                            <a href="#" @click.prevent="filterChart('entries', 7)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 7 dias</a>
                            <a href="#" @click.prevent="filterChart('entries', 10)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 10 dias</a>
                            <a href="#" @click.prevent="filterChart('entries', 30)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 30 dias</a>
                        </div>
                    </div>
                </div>

                <canvas class="web:max-h-[95%]" id="entriesChart"></canvas>
            </div>
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile-std:min-h-[500px] w-[50%] mobile-std:w-full max-w-full border border-gray-200">
                <div class="flex justify-between">
                    <p class="font-medium 2xl:text-2xl text-xl">Saídas</p>

                    <div class="relative">
                        <button
                            @click="toggleDropdown('outputs')"
                            class="flex justify-center items-center p-2 h-10 mobile-std:min-w-16 min-w-32 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-calendar font-semibold mr-2 text-secondary"></i>
                            <p class="font-medium text-secondary mobile-std:hidden">Período</p>
                            <i class="bx bx-chevron-down font-semibold ml-2 mobile-std:ml-0 text-secondary"></i>
                        </button>

                        <div v-if="dropdowns.outputs" class="absolute right-0 w-48 bg-white border rounded shadow-xl">
                            <a href="#" @click.prevent="filterChart('outputs', 7)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 7 dias</a>
                            <a href="#" @click.prevent="filterChart('outputs', 10)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 10 dias</a>
                            <a href="#" @click.prevent="filterChart('outputs', 30)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 30 dias</a>
                        </div>
                    </div>
                </div>

                <canvas class="web:max-h-[95%]" id="outputsChart"></canvas>
           </div>
        </div>
    </BaseLayout>
</template>

<script>
    import { Head } from '@inertiajs/vue3'
    import Chart from 'chart.js/auto';
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';

    export default {
        components: {
            BaseLayout,
            Head,
        },

        props: {
            dayStats: [],
        },

        data() {
            return {
                dropdowns: {
                    invoicing: false,
                    entries: false,
                    outputs: false
                },

                entriesChartSettings: {
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

                outputsChartSettings: {
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

                invoicingChartSettings: {
                    axis: window.innerWidth <= 800 ? 'y' : 'x',
                    type: 'line',
                    name: 'Faturamento (R$)',
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
            },

            toggleDropdown(chartType) {
                this.dropdowns[chartType] = !this.dropdowns[chartType];
            },

            // @todo fix this method's functionality
            async filterChart(chartType, days) {
                let chartSettings = this[`${chartType}ChartSettings`];

                await axios.get(route('dashboard.filter', {
                    period: days,
                    chartType: chartType,
                }))
                .then(response => {
                    chartSettings = response.data;
                })
                .catch (error => {
                    console.error(error);
                });

                this.buildChart(document.getElementById(`${chartType}Chart`), chartSettings);
            }
        },

        mounted() {
            const entriesChart = document.getElementById('entriesChart');
            const outputsChart = document.getElementById('outputsChart');
            const invoicingChart = document.getElementById('invoicingChart');

            this.buildChart(entriesChart, this.entriesChartSettings);
            this.buildChart(outputsChart, this.outputsChartSettings);
            this.buildChart(invoicingChart, this.invoicingChartSettings);
        }
    }
</script>
