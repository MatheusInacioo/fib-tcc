<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-xl 2xl:text-2xl">{{ pageTitle }}</p>
        </div>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <form @submit.prevent="saveForm" class="w-full h-full">
            <div class="form-row flex mb-5 mobile-std:flex-col mobile-std:mb-1">
                <div class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Tipo de Transação</span>
                    <select
                        :readonly="transactionExists"
                        v-model="form.type"
                        name="type"
                        id="type"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="(type, index) in types"
                            :key="index"
                            :value="index"
                        >
                            {{ type }}
                        </option>
                    </select>
                    <div v-if="form.errors.type" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.type }}</div>
                </div>

                <div
                    class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mr-0 relative"
                    v-if="form.type == 0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Fornecedor</span>
                    <input
                        v-model="supplierQuery"
                        @input="searchSuppliers()"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                        type="text"
                        placeholder="Buscar fornecedor..."
                    >
                    <transition name="searchbar">
                        <div
                            v-if="supplierQuery && filteredSuppliers.length"
                            class="max-h-[450px] overflow-y-scroll absolute top-full mt-1 w-full bg-white border border-gray-300 rounded-xl z-10 scrollbar-thin"
                        >
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

                <div
                    v-if="form.type == 1"
                    class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Cliente</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.customer_id"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                        type="number"
                        name="customer_id"
                        id="customer_id"
                        placeholder="ID do Cliente"
                    >
                    <div v-if="form.errors.customer_id" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.customer_id }}</div>
                </div>

                <div
                    v-if="form.customer_id || form.supplier_id"
                    class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Produto</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.product_id"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                        type="number"
                        name="product_id"
                        id="product_id"
                        placeholder="ID do Produto"
                    >
                    <div v-if="form.errors.product_id" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.product_id }}</div>
                </div>
            </div>

            <div class="form-row flex mb-5 mobile-std:flex-col mobile-std:mb-1">
                <div
                    v-if="form.product_id"
                    class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Quantidade</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.quantity"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                        type="number"
                        name="quantity"
                        id="quantity"
                        placeholder="Quantidade"
                    >
                    <div v-if="form.errors.quantity" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.quantity }}</div>
                </div>

                <div
                    v-if="form.quantity"
                    class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Preço</span>
                    <input
                        readonly
                        v-model="form.price"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                        type="number"
                        step="0.01"
                        name="price"
                        id="price"
                        placeholder="Preço Unitário"
                    >
                    <div v-if="form.errors.price" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.price }}</div>
                </div>

                <div
                    v-if="form.quantity"
                    class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Valor Total</span>
                    <input
                        readonly
                        v-model="form.total_amount"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                        type="number"
                        step="0.01"
                        name="total_amount"
                        id="total_amount"
                        placeholder="Valor Total"
                    >
                    <div v-if="form.errors.total_amount" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.total_amount }}</div>
                </div>

                <div
                    v-if="form.quantity"
                    class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Forma de Pagamento</span>
                    <select
                        :readonly="transactionExists"
                        v-model="form.payment_method"
                        name="payment-method"
                        id="payment-method"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="method in paymentMethods"
                            :key="method.id"
                            :value="method"
                        >
                            {{ method }}
                        </option>
                    </select>
                    <div v-if="form.errors.payment_method" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.payment_method }}</div>
                </div>
            </div>

            <div
                v-if="form.quantity"
                class="form-row flex mb-5 mobile-std:flex-col mobile-std:mb-1"
            >
                <div class="form-field flex flex-col 2xl:mr-6 mr-4 mobile-std:mr-0 w-full">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Observações</span>
                    <textarea
                        :readonly="transactionExists"
                        v-model="form.notes"
                        class="border-gray-300 h-[150px] w-full 2xl:text-base text-sm rounded-lg mobile-std:mb-4"
                        name="notes"
                        id="notes"
                        placeholder="Observações sobre a transação (max. 500 caracteres)"
                        maxlength="500"
                    ></textarea>
                    <div v-if="form.errors.notes" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.notes }}</div>
                </div>
            </div>

            <div
                v-if="form.payment_method"
                class="flex mobile-std:justify-between"
            >
                <a
                    v-if="transactionExists"
                    :href="route('transactions.index')"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-primary hover:scale-105 transition-all"
                >
                    Voltar
                </a>
                <a
                    v-if="!transactionExists"
                    :href="route('transactions.index')"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </a>
                <button
                    v-if="!transactionExists"
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

export default {
    components: {
        BaseLayout,
    },

    props: {
        transaction: Object,
    },

    setup() {
        const form = useForm({
            type: null,
            customer_id: null,
            supplier_id: null,
            product_id: null,
            quantity: null,
            price: null,
            total_amount: null,
            payment_method: null,
            notes: null,
        });

        return { form };
    },

    data() {
        return {
            types: ['Compra', 'Venda'],
            paymentMethods: ['Dinheiro', 'Cartão de Crédito', 'Boleto', 'Transferência Bancária'],
            supplierQuery: '',
            customerQuery: '',
            productQuery: '',
            filteredSuppliers: [],
            filteredCustomers: [],
            filteredProducts: [],
        };
    },

    computed: {
        pageTitle() {
            return this.transactionExists ? 'Detalhes da Transação' : 'Nova Transação';
        },

        transactionExists() {
            return this.transaction ? true : false;
        },
    },

    methods: {
        saveForm() {
            return this.form.post(route('transactions.store'));
        },

        buildForm(data) {
            this.form.type = data.type;
            this.form.customer_id = data.customer_id;
            this.form.supplier_id = data.supplier_id;
            this.form.product_id = data.product_id;
            this.form.quantity = data.quantity;
            this.form.price = data.price;
            this.form.total_amount = data.total_amount;
            this.form.payment_method = data.payment_method;
            this.form.notes = data.notes;
        },

        searchSuppliers() {
            axios.get(this.route('transactions.suppliers', this.supplierQuery.toLowerCase()))
                .then(response => {
                    this.filteredSuppliers = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },

    created() {
        if (this.transactionExists) {
            this.buildForm(this.transaction);
        }
    },
};
</script>

<style>
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
