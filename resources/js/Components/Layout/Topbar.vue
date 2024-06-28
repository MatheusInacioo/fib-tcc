<template>
    <div class="mobile-std:bg-primary topbar flex justify-between items-center h-16 bg-white 2xl:mb-4 mb-2 px-5 rounded-xl mobile-std:rounded-none shadow-lg border border-gray-200">
         <!-- Mobile Burger Menu -->
         <button
            @click="toggleMenu = !toggleMenu"
            class="web:hidden mobile-lg:hidden"
        >
            <i class="bx bx-menu text-3xl text-secondary"></i>

            <transition name="burger-menu">
                <div
                    v-if="toggleMenu"
                    class="absolute top-[60px] left-[0px] flex flex-col min-w-[250px] z-10 bg-white border border-gray-200 shadow-lg rounded-xl mx-2"
                >
                    <div class="px-2">
                        <a
                            :href="route('dashboard.index')"
                            class="flex items-center hover:bg-gray-200 transition-all px-4 py-2"
                        >
                            <i class="bx bx-home mr-3 text-2xl text-primary"></i>
                            <p class="font-medium text-gray-800 text-lg"> Início </p>
                        </a>
                    </div>

                    <div
                        v-for="menu in menus"
                        :key="menu.id"
                        class="px-2"
                    >
                        <a
                            v-if="userHasPermission('list', menu.subject)"
                            :href="route(menu.route)"
                            class="flex items-center hover:bg-gray-200 transition-all px-4 py-2"
                        >
                            <i :class="menu.icon + ' mr-3 text-2xl text-primary'"></i>
                            <p class="font-medium text-gray-800 text-lg"> {{ menu.title }} </p>
                        </a>
                    </div>
                </div>
            </transition>
        </button>
        <!--  -->

        <div class="w-[320px] max-w-[500px] searchbar-holder flex flex-col mobile-std:hidden">
            <div class="flex items-center 2xl:w-full my-4 bg-white border border-primary transition-all rounded-xl">
                <input
                    type="text"
                    v-model="searchQuery"
                    placeholder="Buscar na aplicação..."
                    class="w-full border-none focus:outline-none rounded-l-xl"
                >
                <i class="bx bx-search text-lg 2xl:text-xl mx-2"></i>
            </div>

            <transition name="searchbar">
                <div
                    v-if="searchQuery"
                    class="absolute top-[75px] flex flex-col min-w-[320px] z-10 bg-white border border-gray-200 shadow-lg"
                >
                    <div
                        v-for="menu in filteredMenus"
                        :key="menu.id"
                        class="text-left"
                    >
                        <a
                            v-if="userHasPermission('list', menu.subject)"
                            :href="route(menu.route)"
                            class="flex items-center transition-all pl-4 w-full py-2 bg-gray-200"
                        >
                            <p class="text-sm 2xl:text-lg hover:scale-105 transition-all font-medium text-gray-800 w-full"> {{ menu.title }} </p>
                        </a>
                        <a
                            v-if="userHasPermission('list', menu.subject)"
                            v-for="submenu in menu.submenus"
                            :href="route(submenu.route)"
                            class="flex items-center transition-all px-4 py-2"
                        >
                            <p class="2xl:text-base hover:scale-105 transition-all bg-white text-black w-full"> {{ submenu.title }} </p>
                        </a>
                    </div>
                </div>
            </transition>
        </div>

        <div class="dropdown-holder flex flex-col">
            <div
                @click="toggleUserDropdown = !toggleUserDropdown"
                class="user-dropdown flex h-10 items-center transition-all hover:scale-110 cursor-pointer"
            >
                <i
                    :class="{
                        'bx bx-chevron-down' : !toggleUserDropdown,
                        'bx bx-chevron-up' : toggleUserDropdown,
                    }"
                    class="mr-1 text-2xl mobile-std:hidden"
                ></i>
                <p class="text-base 2xl:text-lg font-medium mr-2 mobile-std:hidden">{{ user.name }}</p>
                <i class="web:hidden mobile-lg:hidden bx bxs-user-circle text-4xl text-secondary"></i>
                <i class="mobile-std:hidden bx bxs-user-circle 2xl:text-4xl text-3xl text-primary"></i>
            </div>

            <transition name="dropdown">
                <div
                    v-if="toggleUserDropdown"
                    class="absolute web:top-[80px] mobile-std:top-[60px] right-[30px] flex flex-col min-w-[200px] max-w-[500px] z-10 bg-white border border-gray-200 shadow-lg rounded-b-xl mobile-std:right-[0px] mobile-std:rounded-xl mobile-std:w-full"
                >
                    <div class="flex p-4 border-b border-b-gray-300 bg-primary mobile-std:rounded-t-xl">
                        <a
                            :href="route('users.edit', user.id)"
                            class="flex hover:scale-110 transition-all cursor-pointer"
                        >
                            <i class="bx bxs-user-circle 2xl:text-4xl text-secondary text-3xl mr-2 mobile-std:text-4xl"></i>
                            <div class="flex flex-col">
                                <p class="text-xs 2xl:text-base text-secondary font-semibold mr-2 mobile-std:text-xl">{{ user.name }}</p>
                                <small class="text-secondary mobile-std:text-base">{{ user.role.name }}</small>
                            </div>
                        </a>
                    </div>

                    <div class="group px-2">
                        <a
                            :href="route('settings.index')"
                            class="flex items-center hover:bg-gray-200 transition-all hover:scale-110 px-4 py-2"
                        >
                            <i class="bx bxs-cog mr-3 text-base 2xl:text-xl text-gray-800 mobile-std:text-2xl"></i>
                            <p class="text-sm 2xl:text-base font-medium text-gray-800 mobile-std:text-lg"> Configurações </p>
                        </a>

                        <a
                            @click="toggleConfirmationModal()"
                            class="flex items-center hover:bg-gray-200 transition-all hover:rounded-b-lg hover:scale-110 px-4 py-2 cursor-pointer"
                        >
                            <i class="bx bx-log-out mr-3 text-base 2xl:text-xl text-gray-800 mobile-std:text-2xl"></i>
                            <p class="text-sm 2xl:text-base font-medium text-gray-800 mobile-std:text-lg"> Sair </p>
                        </a>
                    </div>
                </div>
            </transition>
        </div>

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
            user: this.$page.props.auth.user,
            toggleUserDropdown: false,
            toggleStoreDropdown: false,
            toggleMenu: false,
            searchQuery: '',
            showModal: false,
            message: {
                content: '',
                subject: 'exit-system',
            },
            menus: [
                {
                    subject: 'invoicing',
                    title: 'Faturamento',
                    icon: 'bx bx-dollar-circle',
                    route: 'invoicing.index',
                    submenus: [
                        {
                            title: 'Consultar',
                            route: 'invoicing.index',
                        }
                    ],
                },
                {
                    subject: 'transactions',
                    title: 'Transações',
                    icon: 'bx bx-transfer-alt',
                    route: 'transactions.index',
                    submenus: [
                        {
                            title: 'Consultar',
                            route: 'transactions.index',
                        }
                    ],
                },
                {
                    subject: 'customers',
                    title: 'Clientes',
                    icon: 'bx bx-group',
                    route: 'customers.index',
                    submenus: [
                        {
                           title: 'Novo Cliente',
                           route: 'customers.create',
                        }
                    ],
                },
                {
                    subject: 'crm',
                    title: 'CRM',
                    icon: 'bx bx-clipboard',
                    route: 'crm.index',
                    submenus: [
                        {
                            title: 'Novo Cadastro',
                            route: 'crm.create',
                        }
                    ],
                },
                {
                    subject: 'suppliers',
                    title: 'Fornecedores',
                    icon: 'bx bxs-truck',
                    route: 'suppliers.index',
                    submenus: [
                        {
                            title: 'Novo Fornecedor',
                            route: 'suppliers.create',
                        }
                    ],
                },
                {
                    subject: 'products',
                    title: 'Produtos',
                    icon: 'bx bx-purchase-tag-alt',
                    route: 'products.index',
                    submenus: [
                        {
                            title: 'Novo Produto',
                            route: 'products.create',
                        }
                    ],
                },

            ],
        }
    },

    computed: {
        filteredMenus() {
            if (!this.searchQuery) return this.menus;

            return this.menus.filter(menu =>
                menu.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                (menu.submenus && menu.submenus.some(submenu => submenu.title.toLowerCase().includes(this.searchQuery.toLowerCase())))
            );
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
 };
 </script>

 <style scoped>
    .dropdown-enter-active,
    .dropdown-leave-active,
    .burger-menu-enter-active,
    .burger-menu-leave-active,
    .searchbar-enter-active,
    .searchbar-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .dropdown-enter-from,
    .dropdown-leave-to,
    .burger-menu-enter-from,
    .burger-menu-leave-to,
    .searchbar-enter-from,
    .searchbar-leave-to {
        opacity: 0;
        transform: translateY(-20px);
    }

    .dropdown-enter-to,
    .dropdown-leave-from,
    .burger-menu-enter-to,
    .burger-menu-leave-from,
    .searchbar-enter-to,
    .searchbar-leave-from {
        opacity: 1;
        transform: translateY(0);
    }
 </style>
