<template>
    <BaseLayout>
        <p class="font-medium 2xl:text-2xl text-xl mr-4 mb-4">Dashboard</p>
        <div class="flex h-full overflow-y-auto">
            <div class="flex w-full h-full">
                <div class="flex flex-col mr-4 w-1/2 h-full">
                    <div class="h-1/2 w-full rounded-lg border border-gray-200 mb-4 p-2">
                        <canvas id="entryChart"></canvas>
                    </div>
                    <div class="h-1/2 w-full rounded-lg border border-gray-200 p-2">
                        <canvas id="exitChart"></canvas>
                    </div>
                </div>
                <div class="flex rounded-lg shadow-lg w-1/2 h-full border border-gray-200">
                    
                </div>
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
                }
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
                            borderWidth: 1
                        }]
                    },
                    options: {
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

            this.buildChart(entryChart, this.entryChartSettings);
            this.buildChart(exitChart, this.exitChartSettings);
        }
    }
</script>
