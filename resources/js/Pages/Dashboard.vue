<template>
    <BaseLayout>
        <Head title="Dashboard"/>
        <span class="text-2xl font-medium">Resumo do dia</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div class="grid grid-cols-4 gap-4 mobile-std:grid-cols-1 mobile-lg:grid-cols-2 mb-4">
            <div class="info-card h-52 rounded-xl shadow-xl flex flex-col border border-gray-200 transition-all hover:scale-105">
                <div class="flex justify-between items-center h-[33%] bg-success rounded-t-xl p-4">
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Faturamento</span>
                    <i class="bx bx-dollar text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div
                    v-if="dayStats.invoicing.total"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span class="text-2xl mobile-std:text-xl font-medium text-black">{{ dayStats.invoicing.total }}</span>
                    <div class="flex justify-between items-center">
                        <div :class="'web:text-base text-sm font-medium ' + invoicingChangeTextColor ">{{ dayStats.invoicing.change + ' em relação ao dia anterior' }} </div>
                        <a
                            :href="route('dashboard.index')"
                            class="flex justify-center items-center px-4 h-10 bg-success rounded-xl shadow-xl hover:scale-105 transition-all self-end"
                        >
                            <p class="font-medium text-white mobile-std:text-sm">VER</p>
                        </a>
                    </div>
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
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Transações</span>
                    <i class="bx bx-transfer-alt text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div
                    v-if="dayStats.purchases > 0 || dayStats.sales > 0"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">{{ dayStats.purchases + ' compras' }}</span>
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">{{ dayStats.sales + ' vendas' }}</span>
                    <a
                        :href="route('transactions.index')"
                        class="flex justify-center items-center px-4 h-10 bg-blue-500 rounded-xl shadow-xl hover:scale-105 transition-all self-end"
                    >
                        <p class="font-medium text-white mobile-std:text-sm">VER</p>
                    </a>
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

                <div
                    v-if="dayStats.low_products && dayStats.low_products.length > 0"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span class="text-lg mobile-std:text-base font-medium mb-2 text-black">{{ dayStats.low_products.length + ' produtos em baixa quantidade'}}</span>
                    <button
                        @click="toggleProductModal('low')"
                        class="flex justify-center items-center px-4 h-10 bg-yellow-500 rounded-xl shadow-xl hover:scale-105 transition-all self-end"
                    >
                        <p class="font-medium text-white mobile-std:text-sm">VER</p>
                    </button>
                </div>
            </div>

            <div class="info-card h-52 rounded-xl shadow-xl flex flex-col border border-gray-200 transition-all hover:scale-105">
                <div class="flex justify-between items-center h-[33%] bg-red-500 rounded-t-xl p-4">
                    <span class="text-2xl mobile-std:text-xl font-medium text-white">Alertas</span>
                    <i class="bx bx-error text-white text-3xl mobile-std:text-2xl"></i>
                </div>

                <div
                    v-if="dayStats.depleted_products || dayStats.expired_products"
                    class="h-full p-4 flex flex-col justify-between"
                >
                    <span
                        v-if="dayStats.depleted_products.length > 0"
                        class="text-lg mobile-std:text-base font-medium mb-2 text-black"
                    >
                        {{ dayStats.depleted_products.length + ' produtos esgotados'}}
                    </span>
                    <span class="text-lg mobile-std:text-base font-medium text-black">{{ dayStats.expired_products.length + ' produtos vencidos'}}</span>
                    <button
                        @click="toggleProductModal('expired')"
                        class="flex justify-center items-center px-4 h-10 bg-danger rounded-xl shadow-xl hover:scale-105 transition-all self-end"
                    >
                        <p class="font-medium text-white mobile-std:text-sm">VER</p>
                    </button>
                </div>

                <div
                    v-else
                    class="h-full p-4 flex justify-center items-center"
                >
                    <span class="text-xl mobile-std:text-lg font-medium mb-2 text-black">Nenhum alerta iminente. Tudo certo!</span>
                </div>
            </div>
        </div>

        <span class="text-2xl font-medium">Estatísticas</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div class="w-full rounded-xl shadow-lg mb-4 border border-gray-200">
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:max-h-[400px] mobile-std:min-h-[500px] w-full border border-gray-200 mobile-std:mb-4">
                <div class="flex justify-between">
                    <p class="font-medium 2xl:text-2xl text-xl">Faturamento</p>

                    <div class="relative">
                        <button
                            @click="toggleDropdown('invoicing')"
                            class="flex justify-center items-center p-2 h-10 mobile-std:min-w-16 min-w-32 bg-primary rounded-xl text-secondary text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-calendar mr-2 "></i>
                            <p class="font-medium mobile-std:hidden">Período</p>
                            <i class="bx bx-chevron-down font-semibold ml-2 mobile-std:ml-0"></i>
                        </button>

                        <div v-if="dropdowns.invoicing" class="absolute right-0 w-40 text-center bg-white border rounded shadow-xl">
                            <a @click.prevent="filterChart('invoicing', 7)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 7 dias</a>
                            <a @click.prevent="filterChart('invoicing', 10)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 10 dias</a>
                            <a @click.prevent="filterChart('invoicing', 30)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 30 dias</a>
                        </div>
                    </div>
                </div>

                <canvas class="web:max-h-[85%]" id="invoicingChart"></canvas>
            </div>
        </div>

        <div class="flex mobile-std:flex-col w-full">
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile-std:min-h-[500px] w-[50%] mobile-std:w-full max-w-full border border-gray-200 mr-4 mobile-std:mb-4">
                <div class="flex justify-between">
                    <p class="font-medium 2xl:text-2xl text-xl">Compras</p>

                    <div class="relative">
                        <button
                            @click="toggleDropdown('purchases')"
                            class="flex justify-center items-center p-2 h-10 mobile-std:min-w-16 min-w-32 bg-primary rounded-xl text-secondary text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-calendar mr-2"></i>
                            <p class="font-medium mobile-std:hidden">Período</p>
                            <i class="bx bx-chevron-down font-semibold ml-2 mobile-std:ml-0"></i>
                        </button>

                        <div v-if="dropdowns.purchases" class="absolute right-0 w-40 text-center bg-white border rounded shadow-xl">
                            <a @click.prevent="filterChart('purchases', 7)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 7 dias</a>
                            <a @click.prevent="filterChart('purchases', 10)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 10 dias</a>
                            <a @click.prevent="filterChart('purchases', 30)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 30 dias</a>
                        </div>
                    </div>
                </div>

                <canvas class="web:max-h-[95%]" id="purchasesChart"></canvas>
            </div>
            <div class="flex flex-col web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:min-h-[300px] mobile-std:min-h-[500px] w-[50%] mobile-std:w-full max-w-full border border-gray-200">
                <div class="flex justify-between">
                    <p class="font-medium 2xl:text-2xl text-xl">Vendas</p>

                    <div class="relative">
                        <button
                            @click="toggleDropdown('sales')"
                            class="flex justify-center items-center p-2 h-10 mobile-std:min-w-16 min-w-32 bg-primary rounded-xl text-secondary text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-calendar mr-2"></i>
                            <p class="font-medium mobile-std:hidden">Período</p>
                            <i class="bx bx-chevron-down font-semibold ml-2 mobile-std:ml-0"></i>
                        </button>

                        <div v-if="dropdowns.sales" class="absolute right-0 w-40 text-center bg-white border rounded shadow-xl">
                            <a @click.prevent="filterChart('sales', 7)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 7 dias</a>
                            <a @click.prevent="filterChart('sales', 10)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 10 dias</a>
                            <a @click.prevent="filterChart('sales', 30)" class="block px-4 py-2 text-black hover:bg-gray-200">Últimos 30 dias</a>
                        </div>
                    </div>
                </div>

                <canvas class="web:max-h-[95%]" id="salesChart"></canvas>
           </div>
        </div>

        <ProductModal
            :show-modal="showProductModal"
            :products="selectedProducts"
            @close-modal="showProductModal = false"
        />
    </BaseLayout>
</template>

<script>
    import { Head } from '@inertiajs/vue3'
    import Chart from 'chart.js/auto';
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';
    import ProductModal from '@/Components/Utils/ProductModal.vue';

    export default {
        components: {
            BaseLayout,
            Head,
            ProductModal,
        },

        props: {
            dayStats: [],
        },

        data() {
            return {
                showProductModal: false,
                selectedProducts: [],
                dropdowns: {
                    invoicing: false,
                    purchases: false,
                    sales: false
                },

                charts: {
                    invoicing: null,
                    purchases: null,
                    sales: null
                },

                purchasesChartSettings: {
                    axis: window.innerWidth <= 1024 ? 'y' : 'x',
                    type: 'bar',
                    name: 'Compras',
                    labels: [],
                    data: [],
                },

                salesChartSettings: {
                    axis: window.innerWidth <= 1024 ? 'y' : 'x',
                    type: 'bar',
                    name: 'Vendas',
                    labels: [],
                    data: [],
                },

                invoicingChartSettings: {
                    axis: window.innerWidth <= 800 ? 'y' : 'x',
                    type: 'line',
                    name: 'Faturamento (R$)',
                    labels: [],
                    data: [],
                },
            }
        },

        computed: {
            invoicingChangeTextColor() {
                let change = this.dayStats.invoicing.change;

                if (this.dayStats.invoicing.total) {
                    if(change.startsWith('+')) {
                        return 'text-success';
                    } else if (change.startsWith('-')) {
                        return 'text-danger';
                    }
                }

                return '';
            },
        },

        methods: {
            buildChart(ctx, chartSettings) {
                if (this.charts[ctx.id]) {
                    this.charts[ctx.id].destroy();
                }

                this.charts[ctx.id] = new Chart(ctx, {
                    type: chartSettings.type,
                    data: {
                        labels: chartSettings.labels,
                        datasets: [{
                            label: chartSettings.name,
                            data: chartSettings.data,
                            borderWidth: 1,
                            maxBarThickness: 15,
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
                        indexAxis: chartSettings.axis,
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

            async filterChart(chartType, days) {
                let chartSettings = this[`${chartType}ChartSettings`];

                await axios.get(route('dashboard.filter', {
                    period: days,
                    chartType: chartType,
                }))
                .then(response => {
                    chartSettings.labels = Object.keys(response.data);
                    chartSettings.data = Object.values(response.data);
                })
                .catch (error => {
                    console.error(error);
                });

                this.buildChart(document.getElementById(`${chartType}Chart`), chartSettings);
                this.dropdowns[chartType] = false;
            },

            async loadDefaultCharts() {
                await this.filterChart('purchases', 7);
                await this.filterChart('sales', 7);
                await this.filterChart('invoicing', 7);
            },

            toggleProductModal(type) {
                if (type == 'low') {
                    this.selectedProducts = this.dayStats.low_products;
                } else if (type == 'expired') {
                    this.selectedProducts = this.dayStats.expired_products;
                }

                this.showProductModal = !this.showProductModal;
            },
        },

        async mounted() {
            await this.loadDefaultCharts();
        }
    }
</script>
