<template>
    <BaseLayout>
        <Datatable
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
                    icon: 'bx bx-plus font-semibold mr-2',
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
                    label: 'Email',
                    name: 'email',
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
