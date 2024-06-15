<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="low-products-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center px-4 max-h-[70%] w-[30%] mobile-std:w-full"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-full flex flex-col"
                    >
                        <div class="flex justify-between w-full items-center p-4">
                            <p class="mobile-std:text-lg text-xl font-medium">Gerenciar Produtos</p>
                            <button
                                class="2xl:w-8 2xl:h-8 bg-transparent border-none text-primary 2xl:text-4xl hover:scale-125 transition-all flex justify-center items-center"
                                @click="closeModal()"
                            >
                                <i class="mobile-std:text-xl text-3xl bx bx-x"></i>
                            </button>
                        </div>

                        <div class="w-full min-h-px bg-primary"></div>

                        <div class="h-full overflow-y-auto scrollbar-thin">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-200">
                                    <tr class="font-bold text-gray-500 uppercase tracking-wider mobile-std:text-sm">
                                        <th class="py-2 px-4 text-left">Produto</th>
                                        <th class="py-2 px-4 text-center">Quantidade</th>
                                        <th class="py-2 px-4 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                        class="hover:bg-gray-100 transition-all"
                                    >
                                        <td class="py-2 px-4 font-medium mobile-std:text-sm">{{ product.name }}</td>
                                        <td class="py-2 px-4 font-medium mobile-std:text-sm text-center">{{ product.total_amount }}</td>
                                        <td class="py-2 px-4 flex justify-center">
                                            <button
                                                @click=""
                                                class="flex justify-center items-center px-4 py-2 bg-primary rounded-xl shadow-xl hover:scale-105 transition-all self-end"
                                            >
                                                <i class="bx bx-cart-add mr-2 text-secondary text-xl mobile-std:mr-0"></i>
                                                <p class="font-medium text-secondary mobile-std:hidden">Comprar</p>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="w-full min-h-px bg-primary"></div>

                        <div class="flex justify-center w-full items-center p-4">
                            <button
                                type="button"
                                class="2xl:h-10 w-24 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base bg-primary hover:scale-105 transition-all"
                                @click="closeModal()"
                            >
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script>
export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },

        products: {
            type: Array,
            default: () => ([]),
        },
    },

    methods: {
        closeModal() {
            this.$emit('close-modal');
        },
    },
};
</script>

<style scoped>
    .modal-overlay-enter-active,
    .modal-overlay-leave-active {
        transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-overlay-enter-from,
    .modal-overlay-leave-to {
        opacity: 0;
    }

    .modal-body-enter-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
    }

    .modal-body-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-body-enter-from {
        opacity: 0;
        transform: scale(0.8);
    }

    .modal-body-leave-to {
        transform: scale(0.8);
    }
</style>
