<template>
    <div class="sidebar w-80 h-full flex flex-col bg-white shadow-lg">
        <div class="sidebar-header h-24 px-8 flex justify-center items-center mb-4">
            <h4 class="text-4xl font-bold text-orange-400 text-center">LOGO</h4>
        </div>
        <div
            v-for="button in buttons"
            :key="button.id"
            class="menu-item px-12 group"
        >
            <div class="flex items-center h-8 hover:bg-orange-500 hover:rounded-xl hover:text-white transition-all hover:scale-110 p-2">
                <i :class="button.icon + ' mr-5 text-xl text-orange-400 group-hover:text-white'"></i>
                <a
                    :href="route(button.route)"
                    class="text-base font-bold"
                >
                    {{ button.title }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
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
