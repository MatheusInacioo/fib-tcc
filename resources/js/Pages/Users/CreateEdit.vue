<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-xl 2xl:text-2xl">{{ pageTitle }}</p>
        </div>

        <div class="h-px w-full bg-primary my-4"></div>

        <form
            @submit.prevent="saveForm()"
            class="w-full h-full"
        >
            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome do usuário</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do usuário"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                </div>


                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Email do usurário</span>
                    <input
                        v-model="form.email"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Ex: email@email.com"
                    >
                    <div v-if="form.errors.email" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.email }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">
                        <p v-if="! user">Senha</p>
                        <p v-else>Nova senha (opcional)</p>
                    </span>
                    <input
                        v-model="form.password"
                        class="border-gray-300 2xl:w-[370px] w-[250px] 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="password"
                        id="password"
                        placeholder="Senha do usuário"
                    >
                    <div v-if="form.errors.password" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.password }}</div>
                </div>
            </div>

            <div class="flex">
                <a
                    :href="route('users.index')"
                    class="2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    class="2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
                >
                    Salvar
                </button>
            </div>
        </form>
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        BaseLayout,
    },

    props: {
        user: {},
    },

    setup() {
        const form = useForm({
            name: null,
            email: null,
            password: null,
        });

        return { form }
    },

    computed: {
        pageTitle() {
            return this.user ? 'Editar Usuário' : 'Novo Usuário';
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
            return this.form.post(route('users.store'));
        },

        updateUser() {
            return this.form.put(route('users.update', this.user.data.id));
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.email = data.email;
        },
    },

    created() {
        if(this.userExists) {
            this.buildForm(this.user.data);
        }
    },
}
</script>
