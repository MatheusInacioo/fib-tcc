<template>
    <div class="holder mobile:hidden">
        <Transition :name="showBar ? 'sidebar-transition' : 'sidebar-transition-reverse'">
            <div
                v-if="showBar"
                class="sidebar 2xl:w-64 h-screen flex flex-col bg-primary shadow-lg"
            >
                <div class="sidebar-header h-24 px-8 flex justify-center items-center mb-4">
                    <h4 class="text-2xl 2xl:text-4xl font-bold text-secondary text-center">LOGO</h4>
                    <button
                        class="2xl:w-6 2xl:h-6 absolute left-[1vw] top-[35px] bg-secondary text-primary 2xl:text-xl rounded-xl hover:scale-125 transition-all border border-gray-400 flex justify-center items-center"
                        @click="showBar = !showBar"
                    >
                        <i class="bx bx-chevron-left"></i>
                    </button>
                </div>
                <div
                    v-for="button in buttons"
                    :key="button.id"
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
        </Transition>

        <Transition :name="showBar ? 'sidebar-transition-reverse' : 'sidebar-transition'">
            <div
                v-if="!showBar"
                class="sidebar w-14 items-center 2xl:w-auto h-screen flex flex-col bg-primary shadow-lg "
            >
                <div class="sidebar-header h-24 flex justify-center items-center mb-4">
                    <button
                        class="bg-secondary text-primary 2xl:text-xl 2xl:w-6 2xl:h-6 rounded-xl hover:scale-125 transition-all border border-gray-400 flex justify-center items-center"
                        @click="showBar = !showBar">
                        <i class="bx bx-chevron-right"></i>
                    </button>
                </div>
                <div
                    v-for="button in buttons"
                    :key="button.id"
                    class="menu-item px-4 my-0.5 group"
                >
                    <a
                        :href="route(button.route)"
                        class="flex items-center h-8 hover:bg-secondary hover:rounded-lg hover:text-primary transition-all hover:scale-110 p-2"
                    >
                        <i :class="button.icon + ' text-base 2xl:text-xl text-secondary group-hover:text-primary'"></i>
                    </a>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showBar: false,
                buttons: [
                    {
                        title: 'Home',
                        icon: 'bx bx-home-alt-2',
                        route: 'dashboard.index',
                    },
                    {
                        title: 'CRM',
                        icon: 'bx bx-clipboard',
                        route: 'crm.index',
                    },
                    {
                        title: 'Clientes',
                        icon: 'bx bx-group',
                        route: 'customers.index',
                    },
                    {
                        title: 'Fornecedores',
                        icon: 'bx bxs-truck',
                        route: 'suppliers.index',
                    },
                    {
                        title: 'Produtos',
                        icon: 'bx bx-purchase-tag-alt',
                        route: 'products.index',
                    },
                    {
                        title: 'Sair',
                        icon: 'bx bx-log-out',
                        route: 'login.destroy',
                    },
                ],
            }
        }
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
</style>
