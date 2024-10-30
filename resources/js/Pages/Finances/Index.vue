<template>
    <BaseLayout>
        <Head title="Finanças"/>
        <div
            v-if="financialData == 0"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-x-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhum registro encontrado</p>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <Datatable
                :settings="tableSettings"
                :data="tableData"
            />
        </div>

        <NotificationModal
            :show-modal="showModal"
            :message="message"
            @close-modal="toggleModal()"
        />
    </BaseLayout>
</template>

<script>
import { Head } from '@inertiajs/vue3';
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import Datatable from '@/Components/Utils/Datatable.vue';
import NotificationModal from '@/Components/Utils/NotificationModal.vue';

export default {
    components: {
        Head,
        BaseLayout,
        Datatable,
        NotificationModal,
    },

    props: {
        financialData: [],
    },

    data() {
        return {
            tableData: this.financialData,
            message: {},
            showModal: false,
            tableSettings: {
                subject: 'finances',
                title: 'Finanças',
                button_title: null,
                routes: {
                    create: null,
                    export: 'finances.export',
                    edit: null,
                    delete: null,
                },
                columns: [
                    {
                        label: 'Período',
                        name: 'period',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Vendas',
                        name: 'sales_count',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Faturamento',
                        name: 'invoicing',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Despesas',
                        name: 'expenses',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Lucro bruto',
                        name: 'gross_profit',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Margem de lucro',
                        name: 'profit_margin',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Ticket médio',
                        name: 'average_ticket',
                        sortable: true,
                        searchable: true,
                    },
                ],
            },
        }
    },

    methods: {
        toggleModal() {
            this.showModal = ! this.showModal;
        },

        async fetchFinancialData(period, interval, startDate, endDate) {
            let params = {
                group_by: period,
                interval: interval,
                start_date: startDate ? startDate : null,
                end_date: endDate ? endDate : null
            };

            await axios.get(this.route('finances.fetch', params))
                .then(response => {
                    console.log(response.data);
                    this.tableData = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },

    created() {
        setTimeout(() => {
            var flashMessage = this.$page.props.flash;

            if(flashMessage.success) {
                this.showModal = true;

                this.message = {
                    type: 'success',
                    content: flashMessage.success,
                }
            } else if (flashMessage.error) {
                this.showModal = true;

                this.message = {
                    type: 'error',
                    content: flashMessage.error,
                }
            }
        }, 200);
    },
}
</script>
