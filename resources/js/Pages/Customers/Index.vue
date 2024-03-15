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

        <Datatable
            v-else
            :info="tableInfo"
            :columns="columns"
            :data="customers"
        />
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import Datatable from '@/Components/Utils/Datatable.vue';

export default {
    components: {
        BaseLayout,
        Datatable,
    },

    props: {
        customers: [],
    },

    data() {
        return {
            tableInfo: {
                title: 'Clientes',
                button: {
                    title: 'Novo Cliente',
                    route: 'customers.create',
                    icon: 'bx bx-plus',
                },
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
            ]
        }
    },
}
</script>
