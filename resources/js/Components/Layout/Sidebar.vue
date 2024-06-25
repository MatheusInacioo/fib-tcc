<template>
    <div class="holder mobile-std:hidden">
        <Transition :name="showBar ? 'sidebar-transition' : 'sidebar-transition-reverse'">
            <div
                v-if="showBar"
                class="sidebar relative 2xl:w-64 h-screen flex flex-col bg-primary shadow-lg"
            >
                <div class="sidebar-header h-24 px-8 flex justify-center items-center mb-4">
                    <img class="mobile-std:hidden" src="img/app/logo/logo-bw.png" alt="logo">
                    <button
                        class="2xl:w-6 2xl:h-6 absolute -right-[0.70rem] top-[2.2rem] bg-secondary text-primary 2xl:text-xl rounded-xl hover:scale-125 transition-all border border-gray-400 flex justify-center items-center"
                        @click="showBar = !showBar"
                    >
                        <i class="bx bx-chevron-left"></i>
                    </button>
                </div>

                <div class="menu-item px-4 my-0.5 group">
                    <a
                        :href="route('dashboard.index')"
                        class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-orange500 transition-all hover:scale-110 p-2"
                    >
                        <i class="bx bx-home-alt-2 mr-3 text-base 2xl:text-xl text-secondary group-hover:text-primary"></i>
                        <p class="text-sm 2xl:text-base font-medium text-secondary group-hover:text-primary"> Início </p>
                    </a>
                </div>

                <div
                    v-for="button in buttons"
                    :key="button.id"
                >
                    <div
                        v-if="userHasPermission('list', button.subject)"
                        class="menu-item px-4 my-0.5 group"
                    >
                        <a
                            :href="route(button.route)"
                            class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-orange500 transition-all hover:scale-110 p-2"
                        >
                            <i :class="button.icon + ' mr-3 text-base 2xl:text-xl text-secondary group-hover:text-primary'"></i>
                            <p class="text-sm 2xl:text-base font-medium text-secondary group-hover:text-primary"> {{ button.title }} </p>
                        </a>
                    </div>
                </div>

                <div class="menu-item px-4 my-0.5 group">
                    <a
                        :href="route('settings.index')"
                        class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-orange500 transition-all hover:scale-110 p-2"
                    >
                        <i class="bx bxs-cog mr-3 text-base 2xl:text-xl text-secondary group-hover:text-primary"></i>
                        <p class="text-sm 2xl:text-base font-medium text-secondary group-hover:text-primary"> Configurações </p>
                    </a>
                </div>

                <div class="menu-item px-4 my-0.5 group">
                    <a
                        @click="toggleConfirmationModal()"
                        class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-orange500 transition-all hover:scale-110 p-2"
                    >
                        <i class="bx bx-log-out mr-3 text-base 2xl:text-xl text-secondary group-hover:text-primary"></i>
                        <p class="text-sm 2xl:text-base font-medium text-secondary group-hover:text-primary"> Sair </p>
                    </a>
                </div>
            </div>
        </Transition>

        <Transition :name="showBar ? 'sidebar-transition-reverse' : 'sidebar-transition'">
            <div
                v-if="!showBar"
                class="sidebar w-14 items-center 2xl:w-auto h-screen flex flex-col justify-between bg-primary shadow-lg pb-8"
            >
                <div class="flex flex-col">
                    <div class="sidebar-header h-24 flex justify-center items-center mb-4">
                        <button
                            class="bg-secondary text-primary 2xl:text-xl 2xl:w-6 2xl:h-6 rounded-xl hover:scale-125 transition-all border border-gray-400 flex justify-center items-center"
                            @click="showBar = !showBar">
                            <i class="bx bx-chevron-right"></i>
                        </button>
                    </div>

                    <div class="menu-item px-4 my-0.5 group relative">
                        <a
                            :href="route('dashboard.index')"
                            class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-primary transition-all hover:scale-110 p-2"
                        >
                            <i class="bx bx-home-alt-2 text-base 2xl:text-xl text-secondary group-hover:text-primary"></i>
                            <span class="menu-text absolute left-full ml-1 whitespace-nowrap bg-secondary px-2 py-1 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm 2xl:text-base font-medium text-primary">
                                Início
                            </span>
                        </a>
                    </div>

                    <div
                        v-for="button in buttons"
                        :key="button.id"
                    >
                        <div
                            v-if="userHasPermission('list', button.subject)"
                            class="menu-item px-4 my-0.5 group relative"
                        >
                            <a
                                :href="route(button.route)"
                                class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-primary transition-all hover:scale-110 p-2"
                            >
                                <i :class="button.icon + ' text-base 2xl:text-xl text-secondary group-hover:text-primary'"></i>
                                <span class="menu-text absolute left-full ml-1 whitespace-nowrap bg-secondary px-2 py-1 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm 2xl:text-base font-medium text-primary">
                                    {{ button.title }}
                                </span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="flex flex-col">
                    <div class="menu-item px-4 my-0.5 group relative">
                        <a
                            :href="route('settings.index')"
                            class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-primary transition-all hover:scale-110 p-2"
                        >
                            <i class="bx bxs-cog text-base 2xl:text-xl text-secondary group-hover:text-primary"></i>
                            <span class="menu-text absolute left-full ml-1 whitespace-nowrap bg-secondary px-2 py-1 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm 2xl:text-base font-medium text-primary">
                                Configurações
                            </span>
                        </a>
                    </div>

                    <div class="menu-item px-4 my-0.5 group relative">
                        <button
                            @click="toggleConfirmationModal()"
                            class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-primary transition-all hover:scale-110 p-2"
                        >
                            <i class="bx bx-log-out text-base 2xl:text-xl text-secondary group-hover:text-primary"></i>
                            <span class="menu-text absolute left-full ml-1 whitespace-nowrap bg-secondary px-2 py-1 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm 2xl:text-base font-medium text-primary">
                                Sair
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <ConfirmationModal
            :show-modal="showModal"
            :custom-message="message"
            @exit-system="exitSystem()"
            @close-modal="toggleConfirmationModal()"
        />
    </div>
</template>

<script>
    import ConfirmationModal from '@/Components/Utils/ConfirmationModal.vue';

    export default {
        components: {
            ConfirmationModal,
        },

        data() {
            return {
                showBar: false,
                showModal: false,
                message: {
                    content: '',
                    subject: 'exit-system',
                },
                buttons: [
                    {
                        subject: 'transactions',
                        title: 'Transações',
                        icon: 'bx bx-transfer-alt',
                        route: 'transactions.index',
                    },
                    {
                        subject: 'products',
                        title: 'Estoque',
                        icon: 'bx bx-package',
                        route: 'products.index',
                    },
                    {
                        subject: 'customers',
                        title: 'Clientes',
                        icon: 'bx bx-group',
                        route: 'customers.index',
                    },
                    {
                        subject: 'suppliers',
                        title: 'Fornecedores',
                        icon: 'bx bxs-truck',
                        route: 'suppliers.index',
                    },
                    {
                        subject: 'crm',
                        title: 'CRM',
                        icon: 'bx bx-clipboard',
                        route: 'crm.index',
                    },
                ],
            }
        },

        methods: {
            toggleConfirmationModal() {
                this.message.content = 'Deseja realmente sair do sistema?';

                this.showModal = ! this.showModal;
            },

            exitSystem() {
                this.$inertia.visit(route('login.destroy'));
            },
        },
    }
</script>

<style>
    .sidebar-transition-enter-active,
    .sidebar-transition-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .sidebar-transition-enter-from,
    .sidebar-transition-leave-to {
        opacity: 0;
        transform: translateX(-100%);
    }

    .sidebar-transition-enter-to,
    .sidebar-transition-leave-from {
        opacity: 1;
        transform: translateX(0);
    }

    .sidebar-transition-reverse-enter-active,
    .sidebar-transition-reverse-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .sidebar-transition-reverse-enter-from,
    .sidebar-transition-reverse-leave-to {
        opacity: 0;
        transform: translateX(-100%);
    }

    .sidebar-transition-reverse-enter-to,
    .sidebar-transition-reverse-leave-from {
        opacity: 1;
        transform: translateX(0);
    }

    .menu-item .menu-text {
        pointer-events: none;
    }

    .menu-item a:hover .menu-text {
        opacity: 1;
    }
</style>
