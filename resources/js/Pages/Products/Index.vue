<template>
    <BaseLayout>
        <div
            v-if="products == 0"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-error-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhum produto encontrado</p>
            <a
                :href="route('products.create')"
                class="flex justify-center items-center min-w-40 p-2 h-10 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold"></i>
                <p class="font-medium">Novo Produto</p>
            </a>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <Datatable
                :settings="tableSettings"
                :data="formattedProducts"
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
        products: {
            type: Array,
            default: () => ([]),
        },
    },

    data() {
        return {
            message: {},
            showModal: false,
            formattedProducts: [],
            tableSettings: {
                title: 'Produtos',
                button_title: 'Novo produto',
                routes: {
                    create: 'products.create',
                    edit: 'products.edit',
                    delete: 'products.destroy',
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
                        label: 'SKU',
                        name: 'sku',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Marca',
                        name: 'brand',
                        sortable: true,
                        searchable: true,
                    },
                    {
                        label: 'Fornecedor',
                        name: 'supplier_name',
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
        this.formattedProducts = this.products.map(product => ({
            ...product,
            supplier_name: product.supplier.name,
        }));

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