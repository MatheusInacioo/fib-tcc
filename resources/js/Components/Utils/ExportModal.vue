<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="export-modal"
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
                            <p class="mobile-std:text-lg text-xl font-medium">{{ 'Exportar ' + title }}</p>
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
                                        <th class="py-2 px-4 text-left">Coluna</th>
                                        <th class="py-2 px-4 text-center">Selecionar</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr
                                        v-for="column in columns"
                                        :key="column.name"
                                        class="hover:bg-gray-100 transition-all"
                                        :class="{
                                            'hidden' : column.name == 'actions'
                                        }"
                                    >
                                        <td class="py-2 px-4 font-medium mobile-std:text-sm">{{ column.label }}</td>
                                        <td class="py-2 px-4 text-center">
                                            <input
                                                type="checkbox"
                                                class="rounded-lg"
                                                @change="selectColum(column.name, column.label)"
                                                :checked="isSelected(column.name)"
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="w-full min-h-px bg-primary"></div>

                        <div class="flex justify-between w-full items-center p-4">
                            <button
                                type="button"
                                class="2xl:h-10 w-24 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base bg-gray-400 hover:scale-105 transition-all"
                                @click="closeModal()"
                            >
                                Cancelar
                            </button>
                            <button
                                @click="exportData()"
                                class="2xl:h-10 w-24 p-2 rounded-xl font-medium text-sm 2xl:text-base ml-3"
                                :disabled="form.selectedColumns.length <= 0"
                                :class="{
                                    'bg-primary text-secondary hover:scale-105 transition-all' : form.selectedColumns.length > 0,
                                    'bg-gray-300 text-white' : form.selectedColumns.length <= 0,
                                }"
                            >
                                Exportar
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },

        title: {
            type: String,
            default: '',
        },

        exportRoute: {
            type: String,
            default: '',
        },

        columns: {
            type: Array,
            default: () => ([]),
        },
    },

    setup() {
        const form = useForm({
            selectedColumns: [],
        });

        return { form }
    },

    methods: {
        closeModal() {
            this.$emit('close-modal');

            this.form.selectedColumns = [];
        },

        async exportData() {
            try {
                await this.form.post(route(this.exportRoute));

                this.closeModal();
            } catch (error) {
                console.error(error);
            }
        },

        isSelected(columnName) {
            return this.form.selectedColumns.some(column => column.name === columnName);
        },

        selectColum(columnName, columnLabel) {
            const index = this.form.selectedColumns.findIndex(column => column.name === columnName);

            if (index !== -1) {
                this.form.selectedColumns.splice(index, 1);
            } else {
                this.form.selectedColumns.push({
                    name: columnName,
                    label: columnLabel,
                });
            }
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
