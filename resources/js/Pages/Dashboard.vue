<template>
    <BaseLayout>
        <p class="font-medium 2xl:text-2xl text-xl mr-4 mb-4">Dashboard</p>
        <div class="flex h-full overflow-y-auto">
            <div class="flex w-full h-full">
                <div class="flex flex-col mr-4 w-1/2 h-full">
                    <div class="h-1/2 w-full rounded-lg border border-gray-200 mb-4 p-4">
                        <Bar
                            aria-label="Entradas"
                            id="entryBarChart"
                            :options="entryChartOptions"
                            :data="entryChartData"
                        />
                    </div>
                    <div class="h-1/2 w-full rounded-lg border border-gray-200 p-4">
                        <Bar
                            aria-label="Saídas"
                            id="exitBarChart"
                            :options="exitChartOptions"
                            :data="exitChartData"
                        />
                    </div>
                </div>
                <div class="flex rounded-lg shadow-lg w-1/2 h-full border border-gray-200">
                    
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script>
    import BaseLayout from '@/Components/Layout/BaseLayout.vue'; 
    import { Bar } from 'vue-chartjs';
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

    export default {
        components: {
            BaseLayout,
            Bar,
        },

        props: {

        },

        data() {
            return {
                entryChartData: {
                    labels: [ 
                        'January', 
                        'February', 
                        'March', 
                        'April', 
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                     ],
                    datasets: [
                        {
                            label: 'Entradas',
                            backgroundColor: '#5591f2',
                            data: [5, 20, 15, 35, 10, 100, 45, 93, 66, 31, 51, 44]
                        }
                    ]
                },

                entryChartOptions: {
                  responsive: true
                },

                exitChartData: {
                    labels: [ 
                        'January', 
                        'February', 
                        'March', 
                        'April', 
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                     ],
                    datasets: [
                        {
                            label: 'Saídas',
                            backgroundColor: '#5591f2',
                            data: [50, 40, 55, 100, 70, 33, 41, 44, 52, 15, 28, 37]
                        }
                    ]
                },

                exitChartOptions: {
                  responsive: true
                },
            }
        }
    }
</script>
