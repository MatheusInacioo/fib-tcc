<template>
    <BaseLayout>
        <span class="text-2xl mobile-std:text-xl font-medium">Configurações</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div class="grid grid-cols-4 mobile-std:grid-cols-1 mobile-lg:grid-cols-3">
            <a
                :href="route('users.edit', this.$page.props.auth.user.id)"
                class="h-[80px] w-[95%] mobile-std:w-full p-4 rounded-xl shadow-lg mb-4 flex items-center border border-gray-200 hover:scale-105 transition-all bg-white"
            >
                <i class="bx bx-user mr-4 text-2xl text-primary"></i>
                <span class="text-xl mobile-std:text-lg font-medium text-black">Perfil</span>
            </a>
            <a
                v-for="button in buttons"
                :key="button.id"
                :href="route(button.route)"
                class="h-[80px] w-[95%] mobile-std:w-full p-4 rounded-xl shadow-lg mb-4 flex items-center border border-gray-200 hover:scale-105 transition-all bg-white"
            >
                <i :class="button.icon + ' mr-4 text-2xl text-primary'"></i>
                <span class="text-xl mobile-std:text-lg font-medium text-black">{{ button.title }}</span>
            </a>
        </div>
    </BaseLayout>
</template>

<script>
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';

    export default {
        components: {
            BaseLayout,
        },

        data() {
            return {
                buttons: [
                    {
                        title: 'Permissões',
                        icon: 'bx bx-check-square',
                        route: 'dashboard.index',
                    },
                    {
                        title: 'Ajuda e suporte',
                        icon: 'bx bx-help-circle',
                        route: 'dashboard.index',
                    },
                ],
            }
        },
    }
</script>
