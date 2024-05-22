<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-xl 2xl:text-2xl">{{ pageTitle }}</p>
        </div>

        <div class="h-px w-full bg-primary my-4"></div>

        <form
            @submit.prevent="saveForm()"
            class="w-full h-full"
        >
            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome do Produto</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do Produto"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">SKU</span>
                    <input
                        v-model="form.sku"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="sku"
                        id="sku"
                        v-maska
                        data-maska="P####S#####K##"
                        placeholder="P0000S00000K00"
                    >
                    <div v-if="form.errors.sku" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.sku }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Marca</span>
                    <input
                        v-model="form.brand"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="brand"
                        id="brand"
                        placeholder="Marca do Produto"
                    >
                    <div v-if="form.errors.brand" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.brand }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 relative">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Fornecedor</span>
                    <input
                        v-model="supplierQuery"
                        @input="searchSuppliers()"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        placeholder="Buscar fornecedor..."
                    >
                    <transition name="searchbar">
                        <div v-if="supplierQuery && filteredSuppliers.length" class="max-h-[450px] overflow-y-scroll absolute top-full mt-1 w-full bg-white border border-gray-300 rounded-xl z-10 scrollbar-thin">
                            <div
                                v-for="supplier in filteredSuppliers"
                                :key="supplier.id"
                                @click="selectSupplier(supplier)"
                                class="cursor-pointer px-4 py-2 hover:bg-gray-200"
                            >
                                {{ supplier.id + ' - ' + supplier.name }}
                            </div>
                        </div>
                    </transition>
                    <input
                        type="hidden"
                        v-model="form.supplier_id"
                        name="supplier_id"
                        id="supplier_id"
                    >
                    <div v-if="form.errors.supplier_id" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.supplier_id }}</div>
                </div>
            </div>

            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Preço de Compra</span>
                    <input
                        v-model="form.purchase_price"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="number"
                        step="0.01"
                        min="0"
                        name="purchase_price"
                        id="purchase_price"
                        placeholder="Preço de Compra"
                    >
                    <div v-if="form.errors.purchase_price" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.purchase_price }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Preço de Venda</span>
                    <input
                        v-model="form.sale_price"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="number"
                        step="0.01"
                        min="0"
                        name="sale_price"
                        id="sale_price"
                        placeholder="Preço de Venda"
                    >
                    <div v-if="form.errors.sale_price" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.sale_price }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Quantidade em Estoque</span>
                    <input
                        v-model="form.total_amount"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="number"
                        min="0"
                        name="total_amount"
                        id="total_amount"
                        placeholder="Quantidade em Estoque"
                    >
                    <div v-if="form.errors.total_amount" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.total_amount }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Quantidade Mínima</span>
                    <input
                        v-model="form.minimum_amount"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="number"
                        min="0"
                        name="minimum_amount"
                        id="minimum_amount"
                        placeholder="Quantidade Mínima"
                    >
                    <div v-if="form.errors.minimum_amount" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.minimum_amount }}</div>
                </div>
            </div>

            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Localização no Estoque</span>
                    <input
                        v-model="form.storage_location"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="storage_location"
                        id="storage_location"
                        placeholder="Localização no Estoque"
                    >
                    <div v-if="form.errors.storage_location" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.storage_location }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Data de Vencimento (se houver)</span>
                    <input
                        v-model="form.expiry_date"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="date"
                        name="expiry_date"
                        id="expiry_date"
                        placeholder="Localização no Estoque"
                    >
                    <div v-if="form.errors.expiry_date" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.expiry_date }}</div>
                </div>

            </div>

            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4 w-full">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Descrição do Produto</span>
                    <textarea
                        v-model="form.description"
                        class="border-gray-300 h-[150px] w-full 2xl:text-base text-sm rounded-lg"
                        name="description"
                        id="description"
                        maxlength="500"
                        placeholder="Descrição sobre o produto (máx. 500 caracteres)"
                    ></textarea>
                    <div v-if="form.errors.description" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.description }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 w-full">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Informações Adicionais</span>
                    <textarea
                        v-model="form.additional_info"
                        class="border-gray-300 h-[150px] w-full 2xl:text-base text-sm rounded-lg"
                        name="additional_info"
                        id="additional_info"
                        placeholder="Informações adicionais do produto (max. 200 caracteres)"
                    ></textarea>
                    <div v-if="form.errors.additional_info" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.additional_info }}</div>
                </div>
            </div>

            <div class="flex">
                <a
                    :href="route('products.index')"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
                >
                    Salvar
                </button>
            </div>
        </form>
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { vMaska } from "maska"

export default {
    directives: { maska: vMaska },

    components: {
        BaseLayout,
    },

    props: {
        product: {},
        suppliers: {
            type: Array,
            default: () => ({}),
        },
    },

    data() {
        return {
            form: useForm({
                name: '',
                sku: '',
                brand: '',
                supplier_id: '',
                purchase_price: '',
                sale_price: '',
                total_amount: '',
                minimum_amount: '',
                storage_location: '',
                expiry_date: '',
                description: '',
                additional_info: '',
            }),
            supplierQuery: '',
            filteredSuppliers: []
        }
    },

    computed: {
        pageTitle() {
            return this.product ? 'Editar Produto' : 'Novo Produto';
        },

        productExists() {
            return this.product ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.productExists ? this.updateProduct() : this.createProduct();
        },

        createProduct() {
            return this.form.post(route('products.store'));
        },

        updateProduct() {
            return this.form.put(route('products.update', this.product.data.id));
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.sku = data.sku;
            this.form.brand = data.brand;
            this.form.supplier_id = data.supplier_id;
            this.supplierQuery = data.supplier_name;
            this.form.purchase_price = data.purchase_price;
            this.form.sale_price = data.sale_price;
            this.form.total_amount = data.total_amount;
            this.form.minimum_amount = data.minimum_amount;
            this.form.storage_location = data.storage_location;
            this.form.expiry_date = data.expiry_date;
            this.form.description = data.description;
            this.form.additional_info = data.additional_info;
        },

        searchSuppliers() {
            const query = this.supplierQuery.toLowerCase();
                this.filteredSuppliers = this.suppliers.filter(supplier => {
                    return supplier.name.toLowerCase().includes(query) || supplier.id.toString().includes(query);
                });
        },

        selectSupplier(supplier) {
            this.form.supplier_id = supplier.id;
            this.supplierQuery = supplier.name;
            this.filteredSuppliers = [];
        }
    },

    created() {
        if(this.productExists) {
            this.buildForm(this.product.data);
        }
    },
}
</script>

<style scoped>
    .searchbar-enter-active,
    .searchbar-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .searchbar-enter-from,
    .searchbar-leave-to {
        opacity: 0;
        transform: translateY(-20px);
    }

    .searchbar-enter-to,
    .searchbar-leave-from {
        opacity: 1;
        transform: translateY(0);
    }
</style>
