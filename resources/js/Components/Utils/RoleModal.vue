<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="role-modal"
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
                            <p class="mobile-std:text-lg text-xl font-medium">Gerenciar Cargos</p>
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
                                        <th class="py-2 px-4 text-left">Cargo</th>
                                        <th class="py-2 px-4 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr
                                        v-for="role in roles"
                                        :key="role.id"
                                        class="hover:bg-gray-100 transition-all"
                                        :class="{
                                            'hidden' : role.name == 'actions'
                                        }"
                                    >
                                        <td class="py-2 px-4 font-medium mobile-std:text-sm">{{ role.name }}</td>
                                        <td class="py-2 px-4 flex justify-center">
                                            <button
                                                @click="editRole(role)"
                                                class="hover:scale-125 transition-all mr-2 2xl:mr-3"
                                                :class="{ 'mr-0 2xl:mr-0' : role.name == 'Administrador' }"
                                            >
                                                <i class="bx bxs-edit text-lg 2xl:text-xl text-gray-400"></i>
                                            </button>
                                            <button
                                                type="button"
                                                @click="deleteRole(role.id)"
                                                class="hover:scale-125 transition-all text-danger"
                                                :class="{
                                                    'hidden' : role.name == 'Administrador'
                                                }"
                                            >
                                                <i class="bx bxs-trash text-lg 2xl:text-xl"></i>
                                            </button>
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
                                Fechar
                            </button>
                            <button
                                type="button"
                                class="2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base bg-primary hover:scale-105 transition-all"
                                @click="toggleInputModal()"
                            >
                                Criar Cargo
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>

            <ConfirmationModal
                :show-modal="showConfirmationModal"
                :custom-message="message"
                @confirm-delete="confirmDelete()"
                @close-modal="toggleConfirmationModal()"
            />

            <InputModal
                :role="selectedRole"
                :show-modal="showInputModal"
                @close-modal="this.showInputModal = false"
            />
        </div>
    </Transition>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import ConfirmationModal from '@/Components/Utils/ConfirmationModal.vue';
import InputModal from '@/Components/Utils/InputModal.vue';

export default {
    components: {
        ConfirmationModal,
        InputModal,
    },

    props: {
        showModal: {
            type: Boolean,
            default: false,
        },

        roles: {},
    },

    setup() {
        const form = useForm({
            role_name: null,
        });

        return { form }
    },

    data() {
        return {
            showConfirmationModal: false,
            showInputModal: false,
            message: null,
            selectedRole: null,
        }
    },

    methods: {
        closeModal() {
            this.$emit('close-modal');
        },

        editRole(role) {
            this.selectedRole = {
                id: role.id,
                name: role.name,
            };
            
            this.toggleInputModal();
        },

        deleteRole(roleId) {
            this.toggleConfirmationModal();
            this.selectedRole = roleId;
        },

        toggleConfirmationModal() {
            this.showConfirmationModal = ! this.showConfirmationModal;
            this.message = {
                subject: 'delete-role',
                content: `Ao excluir esse cargo, <strong>TODOS</strong> os usuários vinculados a ele ficarão sem cargo e não poderão realizar praticamente nenhuma ação no sistema. Certifique-se de atribuir um novo cargo a esses usuários antes de prosseguir.`,
            };
        },

        toggleInputModal() {
            this.showInputModal = ! this.showInputModal;
        },

        async confirmDelete() {
            try {
                await axios.post(this.route('roles.destroy', this.selectedRole));

                this.selectedRole = null;
                this.toggleConfirmationModal();
                this.showModal = false;
            } catch (error) {
                console.error(error);
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
