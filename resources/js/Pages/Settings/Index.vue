<template>
    <BaseLayout>
        <Head title="Configurações"/>
        <div class="flex items-center">
            <button
                type="button"
                @click="goBack()"
            >
                <i class="bx bx-left-arrow-alt text-3xl hover:scale-110 transition-all mr-2"></i>
            </button>
            <span class="text-2xl mobile-std:text-xl font-medium">Configurações</span>
        </div>

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
                :class="{
                    'hidden' :
                        button.title == 'Permissões' && !userIsAdmin ||
                        button.title == 'Usuários' && !userHasPermission('list', 'users')
                }"
            >
                <i :class="button.icon + ' mr-4 text-2xl text-primary'"></i>
                <span class="text-xl mobile-std:text-lg font-medium text-black">{{ button.title }}</span>
            </a>
        </div>

        <NotificationModal
            :show-modal="showModal"
            :message="message"
            @close-modal="toggleModal()"
        />
    </BaseLayout>
</template>

<script>
    import { Head } from '@inertiajs/vue3';
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';
    import NotificationModal from '@/Components/Utils/NotificationModal.vue';

    export default {
        components: {
            Head,
            BaseLayout,
            NotificationModal,
        },

        data() {
            return {
                message: {},
                showModal: false,
                buttons: [
                    {
                        title: 'Usuários',
                        icon: 'bx bx-group',
                        route: 'users.index',
                    },
                    {
                        title: 'Cargos',
                        icon: 'bx bx-briefcase',
                        route: 'permissions.index',
                    },
                    {
                        title: 'Permissões',
                        icon: 'bx bx-check-square',
                        route: 'permissions.index',
                    },
                    {
                        title: 'Ajuda e suporte',
                        icon: 'bx bx-help-circle',
                        route: 'dashboard.index',
                    },
                ],
            }
        },

        methods: {
            toggleModal() {
                this.showModal = ! this.showModal;
            },
        },

        created() {
            setTimeout(() => {
                var flashMessage = this.$page.props.flash;

                if(flashMessage.success) {
                    this.showModal = true;

                    this.message = {
                        type: 'success',
                        content: flashMessage.success,
                    }
                } else if (flashMessage.error) {
                    this.showModal = true;

                    this.message = {
                        type: 'error',
                        content: flashMessage.error,
                    }
                }
            }, 200);
        }
    }
</script>
