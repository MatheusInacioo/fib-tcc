<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="confirmation-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center justify-center h-[400px] px-4 text-center w-[500px]"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full p-4 md:p-5 flex flex-col"
                    >
                        <div class="text-center h-full flex flex-col justify-between">
                            <i class="bx bx-error text-yellow-500 text-8xl mb-4"></i>
                            <h3 v-if="! customMessage" class="mb-4 text-lg font-normal text-black">
                                Deseja realmente excluir esse item? <br />
                                Esta ação é irreversível.
                            </h3>
                            <h3
                                v-if="customMessage"
                                v-html="customMessage.content"
                                class="mb-4 text-lg font-normal text-black"
                            ></h3>
                            <div class="flex justify-between w-full">
                                <button
                                    type="button"
                                    class="flex justify-center h-10 w-24 px-2 py-2 bg-gray-400 text-white font-medium rounded-lg hover:scale-110 transition-all"
                                    @click="closeModal()"
                                >
                                    Cancelar
                                </button>
                                <button
                                    v-if="! customMessage || customMessage.subject == 'delete-role'"
                                    @click="confirmDelete()"
                                    class="flex justify-center items-center h-10 w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    <span v-if="!isLoading">Excluir</span>
                                    <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
                                </button>
                                <button
                                    v-if="customMessage && customMessage.subject == 'close-contract'"
                                    @click="closeContract()"
                                    class="flex justify-center items-center h-10 w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    <span v-if="!isLoading">Confirmar</span>
                                    <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
                                </button>
                                <a
                                    v-if="customMessage && customMessage.subject == 'export-data'"
                                    :href="route(exportRoute)"
                                    @click="showModal = false"
                                    class="flex justify-center items-center h-10 w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    <span v-if="!isLoading">Exportar</span>
                                    <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
                                </a>
                                <button
                                    v-if="customMessage && customMessage.subject == 'exit-system'"
                                    @click="exitSystem()"
                                    class="flex justify-center items-center h-10 w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    <span v-if="!isLoading">Sair</span>
                                    <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
                                </button>
                            </div>
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
        exportRoute: '',

        showModal: {
            type: Boolean,
            default: false,
        },

        customMessage: {
            type: String,
            default: '',
        },
    },

    data() {
        return {
            isLoading: false,
        }
    },

    methods: {
        confirmDelete() {
            this.isLoading = true;
            this.$emit('confirm-delete');
        },

        closeContract() {
            this.isLoading = true;
            this.$emit('close-contract');
        },

        exitSystem() {
            this.isLoading = true;
            this.$emit('exit-system');
        },

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
