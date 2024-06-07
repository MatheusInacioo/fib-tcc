<template>
    <BaseLayout>
        <Head title="Transações"/>
        <div
            v-if="transactions == 0 || ! transactions"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-x-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold mobile-std:text-xl text-2xl mb-5">Nenhuma transação encontrada</p>
            <a
                :href="route('transactions.create')"
                class="flex justify-center items-center min-w-40 p-2 h-10 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold"></i>
                <p class="font-medium">Nova Transação</p>
            </a>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <Datatable
                :settings="tableSettings"
                :data="transactions"
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
        transactions: [],
    },

    data() {
        return {
            message: {},
            showModal: false,
            tableSettings: {
                subject: 'transactions',
                title: 'Transações',
                button_title: 'Nova Transação',
                routes: {
                    create: 'transactions.create',
                    export: 'transactions.export',
                    view: 'transactions.view',
                    delete: 'transactions.destroy',
                },
                columns: [
                    {
                        label: 'ID',
                        name: 'id',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Tipo',
                        name: 'type',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Produto',
                        name: 'product_name',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Valor',
                        name: 'formatted_amount',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Pagamento',
                        name: 'payment_method',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Data',
                        name: 'date',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Usuário',
                        name: 'user_name',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Ações',
                        name: 'actions',
                        sortable: false,
                        searchable: false,
                    },
                ],
            },
        }
    },

    methods: {
        toggleModal() {
            this.showModal = ! this.showModal;
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
