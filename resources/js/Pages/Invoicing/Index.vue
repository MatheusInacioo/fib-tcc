<template>
    <BaseLayout>
        <Head title="Gestão de Finanças" />
        <div class="p-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <span class="text-2xl font-medium">Olá, [Usuário]! Gestão de Finanças</span>
                <div class="bg-blue-500 text-white rounded-full px-4 py-2 shadow-lg">
                    Total Balance: <span class="font-bold">$51,213</span>
                </div>
            </div>

            <!-- Overview Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-xl font-semibold">Receita Atual</h2>
                    <p class="text-green-500 text-2xl font-bold">+ $729</p>
                    <span class="text-gray-500">Este mês</span>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-xl font-semibold">Despesa Atual</h2>
                    <p class="text-red-500 text-2xl font-bold">- $372</p>
                    <span class="text-gray-500">Este mês</span>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-xl font-semibold">Saldo Total</h2>
                    <p class="text-blue-500 text-2xl font-bold">$51,213</p>
                    <span class="text-gray-500">Acumulado</span>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-xl font-semibold">Transações Rápidas</h2>
                    <div class="flex space-x-2 mt-2">
                        <button class="bg-blue-200 text-blue-600 px-4 py-2 rounded-lg">Mobile</button>
                        <button class="bg-purple-200 text-purple-600 px-4 py-2 rounded-lg">Casa</button>
                        <button class="bg-yellow-200 text-yellow-600 px-4 py-2 rounded-lg">Add</button>
                    </div>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
                <!-- Outcome Categories -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4">Categorias de Despesa</h2>
                    <div class="flex justify-between items-center">
                        <div class="w-1/2">
                            <canvas id="outcomeChart"></canvas>
                        </div>
                        <ul class="w-1/2 space-y-2">
                            <li><span class="text-yellow-400">●</span> Investimentos: $2,313.5</li>
                            <li><span class="text-green-400">●</span> Transporte: $1,283.5</li>
                            <li><span class="text-blue-400">●</span> Alimentação: $629.5</li>
                            <li><span class="text-red-400">●</span> Outros: $501.5</li>
                        </ul>
                    </div>
                </div>

                <!-- Income Categories -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4">Categorias de Receita</h2>
                    <div class="flex justify-between items-center">
                        <div class="w-1/2">
                            <canvas id="incomeChart"></canvas>
                        </div>
                        <ul class="w-1/2 space-y-2">
                            <li><span class="text-orange-400">●</span> Dividendos: $3,103.5</li>
                            <li><span class="text-blue-400">●</span> Salário: $2,268.5</li>
                            <li><span class="text-purple-400">●</span> Transações: $1,718.8</li>
                            <li><span class="text-green-400">●</span> Outros: $911.5</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions & Balance History -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Recent Transactions -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4">Transações Recentes</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="pb-2">Descrição</th>
                                <th class="pb-2">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Emirates</td>
                                <td class="text-red-500">- $683.00</td>
                            </tr>
                            <tr>
                                <td>Cinema</td>
                                <td class="text-red-500">- $17.25</td>
                            </tr>
                            <tr>
                                <td>Starbucks</td>
                                <td class="text-red-500">- $14.99</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Balance History Chart -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4">Histórico de Saldo</h2>
                    <canvas id="balanceHistoryChart"></canvas>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script>
import { Head } from '@inertiajs/vue3';
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import { Chart } from 'chart.js';

export default {
    components: {
        BaseLayout,
        Head,
    },
    mounted() {
        this.renderCharts();
    },
    methods: {
        renderCharts() {
            const outcomeCtx = document.getElementById('outcomeChart').getContext('2d');
            const incomeCtx = document.getElementById('incomeChart').getContext('2d');
            const balanceHistoryCtx = document.getElementById('balanceHistoryChart').getContext('2d');

            new Chart(outcomeCtx, {
                type: 'pizza',
                data: {
                    labels: ['Investimento', 'Transporte', 'Alimentação', 'Outros'],
                    datasets: [{
                        data: [2313.5, 1283.5, 629.5, 501.5],
                        backgroundColor: ['#FBBF24', '#34D399', '#60A5FA', '#F87171'],
                    }],
                },
            });

            new Chart(incomeCtx, {
                type: 'pie',
                data: {
                    labels: ['Dividendos', 'Salário', 'Transações', 'Outros'],
                    datasets: [{
                        data: [3103.5, 2268.5, 1718.8, 911.5],
                        backgroundColor: ['#FB923C', '#60A5FA', '#A78BFA', '#34D399'],
                    }],
                },
            });

            new Chart(balanceHistoryCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [{
                        label: 'Saldo',
                        data: [2000, 3000, 5000, 7000, 9000],
                        borderColor: '#3B82F6',
                        fill: false,
                        tension: 0.1,
                    }],
                },
            });
        },
    },
}
</script>