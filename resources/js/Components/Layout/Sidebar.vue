<template>
    <div class="holder">
        <Transition :name="showBar ? 'sidebar-transition' : 'sidebar-transition-reverse'">
            <div
                v-if="showBar"
                class="sidebar 2xl:w-64 h-screen flex flex-col bg-white border border-l-gray-200 shadow-lg"
            >
                <div class="sidebar-header h-24 px-8 flex justify-center items-center mb-4">
                    <h4 class="text-2xl 2xl:text-4xl font-bold text-orange-500 text-center">LOGO</h4>
                    <button
                        class="2xl:w-6 2xl:h-6 absolute left-[244px] top-[35px] bg-orange-500 text-white 2xl:text-xl rounded-xl hover:scale-125 transition-all"
                        @click="showBar = !showBar"
                    >
                        <i class="bx bx-chevron-left"</i>
                    </button>
                </div>
                <div
                    v-for="button in buttons"
                    :key="button.id"
                    class="menu-item px-4 my-0.5 group"
                >
                    <a
                        :href="route(button.route)"
                        class="flex items-center h-8 hover:bg-orange-500 hover:rounded-xl hover:text-white transition-all hover:scale-110 p-2"
                    >
                        <i :class="button.icon + ' mr-3 text-base 2xl:text-xl text-orange-500 group-hover:text-white'"></i>
                        <p class="text-sm 2xl:text-base font-medium text-black group-hover:text-white"> {{ button.title }} </p>
                    </a>
                </div>
            </div>
        </Transition>

        <Transition :name="showBar ? 'sidebar-transition-reverse' : 'sidebar-transition'">
            <div
                v-if="!showBar"
                class="sidebar w-14 items-center 2xl:w-auto h-screen flex flex-col bg-white border border-l-gray-200 shadow-lg"
            >
                <div class="sidebar-header h-24 flex justify-center items-center mb-4">
                    <button
                        class="bg-orange-500 text-white 2xl:text-xl 2xl:w-6 2xl:h-6 rounded-xl hover:scale-125 transition-all"
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
                        class="flex items-center h-8 hover:bg-orange-500 hover:rounded-xl hover:text-white transition-all hover:scale-110 p-2"
                    >
                        <i :class="button.icon + ' text-base 2xl:text-xl text-orange-500 group-hover:text-white'"></i>
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
                        icon: 'bx bx-package',
                        route: 'dashboard.index',
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
