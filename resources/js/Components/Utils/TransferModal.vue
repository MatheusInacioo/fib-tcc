<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="transfer-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center px-4 max-h-[70%] w-[30%] mobile-lg:w-[70%] mobile-std:w-full"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-full flex flex-col"
                    >
                        <div class="flex justify-between w-full items-center p-4">
                            <p class="mobile-std:text-lg text-xl font-medium">Transferir Produto</p>
                            <button
                                class="2xl:w-8 2xl:h-8 bg-transparent border-none text-primary 2xl:text-4xl hover:scale-125 transition-all flex justify-center items-center"
                                @click="closeModal()"
                            >
                                <i class="mobile-std:text-xl text-3xl bx bx-x"></i>
                            </button>
                        </div>

                        <div class="max-h-[400px] overflow-y-auto scrollbar-thin px-4">
                            <div class="flex w-full">
                                <div class="form-field flex flex-col mobile-std:mb-4 mobile-std:mr-0 mr-4">
                                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Loja</span>
                                    <select
                                        name="shop"
                                        id="shop"
                                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                                    >
                                        <option>
                                            TESTE
                                        </option>
                                    </select>
                                    <!-- <div v-if="form.errors.shop_id" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.shop_id }}</div> -->
                                </div>
                                <div class="form-field flex flex-col">
                                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Quantidade</span>
                                    <input
                                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                                        type="number"
                                        min="0"
                                        name="minimum_amount"
                                        id="minimum_amount"
                                        placeholder="Quantidade"
                                    >
                                    <!-- <div v-if="form.errors.minimum_amount" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.minimum_amount }}</div> -->
                                </div>
                            </div>
                        </div>

                        <!-- <div class="w-full min-h-px bg-primary"></div> -->

                        <div class="flex justify-between p-4">
                            <button
                                type="button"
                                class="flex justify-center h-10 w-24 px-2 py-2 bg-gray-400 text-white font-medium rounded-lg hover:scale-110 transition-all"
                                @click="closeModal()"
                            >
                                Cancelar
                            </button>
                            <button
                                @click="transferProduct(product.id)"
                                :disabled="isLoading"
                                class="flex justify-center items-center h-10 w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                            >
                                <span v-if="!isLoading">Transferir</span>
                                <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
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

        product: {},
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
