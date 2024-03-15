<template>
    <div class="holder">
        <div
            v-if="showBar"
            class="sidebar w-64 h-full flex flex-col bg-white border border-l-gray-200 shadow-lg"
        >
            <div class="sidebar-header h-24 px-8 flex justify-between items-center mb-4">
                <h4 class="text-4xl font-bold text-orange-500 text-center">LOGO</h4>
                <button @click="showBar = !showBar">
                    <i class="bx bx-chevron-left bg-orange-500 text-white text-xl w-6 rounded-xl"></i>
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
                    <i :class="button.icon + ' mr-3 text-xl text-orange-500 group-hover:text-white'"></i>
                    <p class="text-base font-medium text-black group-hover:text-white"> {{ button.title }} </p>
                </a>
            </div>
        </div>

        <div
            v-if="! showBar"
            class="sidebar w-auto h-full flex flex-col bg-white border border-l-gray-200 shadow-lg"
        >
            <div class="sidebar-header h-24 flex justify-center items-center mb-4">
                <button @click="showBar = !showBar">
                    <i class="bx bx-chevron-right bg-orange-500 text-white text-xl w-6 rounded-xl"></i>
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
                    <i :class="button.icon + ' text-xl text-orange-500 group-hover:text-white'"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showBar: true,
                buttons: [
                    {
                        title: 'Home',
                        icon: 'bx bx-home-alt-2',
                        route: 'dashboard.index',
                    },
                    {
                        title: 'Minha Loja',
                        icon: 'bx bx-edit',
                        route: 'dashboard.index',
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
                        title: 'Configurações',
                        icon: 'bx bx-cog',
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
