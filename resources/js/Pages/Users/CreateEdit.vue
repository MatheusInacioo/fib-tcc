<template>
    <BaseLayout>
        <Head :title="pageTitle"/>
        <div class="flex items-center">
            <a
                :href="route('users.index')"
            >
                <i class="bx bx-left-arrow-alt text-3xl hover:scale-110 transition-all mr-2"></i>
            </a>
            <span class="text-2xl mobile-std:text-xl font-medium">{{ pageTitle }}</span>
        </div>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <form
            @submit.prevent="saveForm()"
            class="w-full h-full"
        >
            <div class="form-row grid grid-cols-4 mobile-std:grid-cols-1 mobile-lg:grid-cols-3 gap-4">
                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome do usuário</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do usuário"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Email do usurário</span>
                    <input
                        v-model="form.email"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Ex: email@email.com"
                    >
                    <div v-if="form.errors.email" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.email }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">
                        <p v-if="! user">Senha</p>
                        <p v-else>Nova senha <small>(opcional)</small></p>
                    </span>
                    <input
                        v-model="form.password"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="password"
                        id="password"
                        placeholder="Senha do usuário"
                    >
                    <div v-if="form.errors.password" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.password }}</div>
                </div>

                <div
                    class="form-field flex flex-col mr-4 mb-4 mobile-std:mb-4 mobile-std:mr-0"
                    :class="{
                        'hidden' : !userIsAdmin
                    }"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Cargo</span>
                    <select
                        v-model="form.role_id"
                        name="role"
                        id="role"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.role_id" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.role_id }}</div>
                </div>
            </div>

            <div class="flex mobile-std:justify-between">
                <a
                    :href="route('users.index')"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    :disabled="isLoading"
                    class="flex justify-center items-center w-24 2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
                >
                    <span v-if="!isLoading">Salvar</span>
                    <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
                </button>
            </div>
        </form>
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';

export default {
    components: {
        Head,
        BaseLayout,
    },

    props: {
        user: {},
        roles: {},
    },

    setup() {
        const form = useForm({
            name: null,
            email: null,
            password: null,
            role_id: null,
        });

        return { form }
    },

    data() {
        return {
            isLoading: false,
        }
    },

    computed: {
        pageTitle() {
            if(! this.user) {
                return 'Novo Usuário';
            } else if (this.user.data.id != this.$page.props.auth.user.id) {
                return 'Editar Usuário';
            }

            return 'Editar Perfil';
        },

        userExists() {
            return this.user ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.userExists ? this.updateUser() : this.createUser();
        },

        createUser() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.post(route('users.store'), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        updateUser() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.put(route('users.update', this.user.data.id), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.email = data.email;
            this.form.role_id = data.role_id;
        },
    },

    created() {
        if(this.userExists) {
            this.buildForm(this.user.data);
        }
    },
}
</script>
