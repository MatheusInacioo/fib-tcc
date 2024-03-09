<template>
    <div class="sidebar w-80 h-full flex flex-col bg-white shadow-lg">
        <div class="sidebar-header h-24 px-8 flex justify-center items-center mb-4">
            <h4 class="text-4xl font-bold text-orange-400 text-center">LOGO</h4>
        </div>
        <div
            v-for="button in buttons"
            :key="button.id"
            class="menu-item px-12 mb-4"
        >
            <div class="flex items-center">
                <i :class="button.icon + ' mr-5 text-2xl font-bold text-orange-400'"></i>
                <a
                    :href="route(button.route)"
                    class="text-xl font-bold"
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
