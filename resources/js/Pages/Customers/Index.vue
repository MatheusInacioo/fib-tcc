<template>
    <BaseLayout>
        <div
            v-if="! customers"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-error-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhum cliente encontrado</p>
            <a
                :href="route('customers.create')"
                class="flex justify-center items-center w-40 h-10 bg-orange-500 rounded-xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold"></i>
                <p class="font-medium">Novo Cliente</p>
            </a>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <Datatable
                :info="tableInfo"
                :data="customers"
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
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import Datatable from '@/Components/Utils/Datatable.vue';
import NotificationModal from '@/Components/Utils/NotificationModal.vue';

export default {
    components: {
        BaseLayout,
        Datatable,
        NotificationModal,
    },

    props: {
        customers: [],
    },

    data() {
        return {
            message: '',
            showModal: false,
            tableInfo: {
                title: 'Clientes',
                button_title: 'Novo Cliente',
                routes: {
                    create: 'customers.create',
                    edit: 'customers.edit',
                    delete: 'customers.destroy',
                },
                columns: [
                    {
                        label: 'ID',
                        name: 'id',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Nome',
                        name: 'name',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'CNPJ',
                        name: 'cnpj',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Email',
                        name: 'email',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Responsável',
                        name: 'responsible',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Segmento',
                        name: 'segment',
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
        var flash = this.$page.props.flash;

        if(flash) {
            this.showModal = true;

             if(flash['create-success']) {
                this.message = flash['create-success'];
             } else if (flash['update-success']) {
                this.message = flash['update-success'];
             } else if (flash['destroy-success']) {
                this.message = flash['destroy-success'];
             }

             if(flash['create-error']) {
                this.message = flash['create-error'];
             } else if (flash['update-error']) {
                this.message = flash['update-error'];
             } else if (flash['destroy-error']) {
                this.message = flash['destroy-error'];
             }
        }
    },
}
</script>
