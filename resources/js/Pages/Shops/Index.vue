<template>
    <BaseLayout>
        <Head title="Lojas"/>
        <div
            v-if="shops == 0"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-x-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhuma loja encontrada</p>
            <a
                :href="route('shops.create')"
                class="flex justify-center items-center min-w-40 p-2 h-10 bg-primary rounded-xl text-secondary text-lg font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold"></i>
                <p class="font-medium">Nova Loja</p>
            </a>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <Datatable
                :settings="tableSettings"
                :data="shops"
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
        shops: [],
    },

    data() {
        return {
            message: {},
            showModal: false,
            tableSettings: {
                subject: 'shops',
                title: 'Lojas',
                button_title: 'Nova Loja',
                routes: {
                    create: 'shops.create',
                    export: 'shops.export',
                    edit: 'shops.edit',
                    delete: 'shops.destroy',
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
                        label: 'Local',
                        name: 'location',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Empresa',
                        name: 'company_name',
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
