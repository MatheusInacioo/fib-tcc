<template>
    <div>
        <Head title="Redefinir Senha"/>
        <div class="login-screen w-screen h-screen flex justify-center items-center bg-[url('/img/app/background.jpg')] bg-center bg-cover font-roboto">
            <div class="mobile-std:h-full mobile-std:w-full w-[500px] shadow-2xl rounded-xl mobile-std:rounded-none bg-gray-800 bg-opacity-20 mobile-std:bg-white backdrop-filter backdrop-blur-xl flex flex-col justify-center p-4">
                <div class="flex flex-col justify-center items-center mb-10">
                    <img class="mobile-std:hidden" width="300" src="/img/app/logo/logo-bw.png" alt="logo">
                    <img class="web:hidden mobile-lg:hidden" width="300" src="/img/app/logo/logo.png" alt="logo">
                </div>
                <form
                    method="POST"
                    class="flex flex-col"
                    @submit.prevent="resetPassword()"
                >
                    <div class="grid grid-cols-1 gap-4">
                        <input type="hidden" name="token" :value="form.token">
                        <div class="flex flex-col">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Email</label>
                            <input
                                v-model="form.email"
                                class="h-12 rounded-xl bg-transparent border-gray-500 mobile-std:border-primary hover:border-secondary focus:border-secondary transition-all text-secondary mobile-std:text-black"
                                type="email"
                                name="email"
                                placeholder="Digite seu email..."
                            >
                            <span v-if="form.errors.email" class="text-red-500 text-base font-semibold">{{ form.errors.email }}</span>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Nova Senha</label>
                            <div class="flex border border-gray-500 mobile-std:border-primary rounded-xl hover:border-secondary focus:border-secondary transition-all">
                                <input
                                    v-model="form.password"
                                    class="w-full h-12 rounded-l-xl bg-transparent border-none outline-none text-secondary mobile-std:text-black"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Digite a nova senha..."
                                >
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword">
                                    <i
                                        class="text-xl w-10 text-secondary mobile-std:text-primary"
                                        :class="{ 'bx bx-hide' : showPassword, 'bx bx-show' : !showPassword }"
                                    ></i>
                                </button>
                            </div>
                            <span v-if="form.errors.password" class="text-danger text-base font-semibold mb-3">{{ form.errors.password }}</span>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Confirme a Senha</label>
                            <div class="flex border border-gray-500 mobile-std:border-primary rounded-xl hover:border-secondary focus:border-secondary transition-all">
                                <input
                                    v-model="form.password_confirmation"
                                    class="w-full h-12 rounded-l-xl bg-transparent border-none outline-none text-secondary mobile-std:text-black"
                                    :type="showPasswordConfirmation ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Confirme a nova senha..."
                                >
                                <button
                                    type="button"
                                    @click="showPasswordConfirmation = !showPasswordConfirmation">
                                    <i
                                        class="text-xl w-10 text-secondary mobile-std:text-primary"
                                        :class="{ 'bx bx-hide' : showPasswordConfirmation, 'bx bx-show' : !showPasswordConfirmation }"
                                    ></i>
                                </button>
                            </div>
                            <span v-if="form.errors.password_confirmation" class="text-danger text-base font-semibold mb-3">{{ form.errors.password_confirmation }}</span>
                        </div>

                        <button
                            type="submit"
                            :disabled="isLoading"
                            class="flex justify-center items-center mt-4 w-full h-10 bg-primary rounded-xl text-secondary font-medium shadow-xl hover:scale-105 transition-all"
                        >
                            <span v-if="!isLoading">Redefinir Senha</span>
                            <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { Head } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/vue3';

    export default {
        components: {
            Head,
        },

        props: {
            token: String,
        },

        data() {
            return {
                isLoading: false,
                showPassword: false,
                showPasswordConfirmation: false,
            }
        },

        setup(props) {
            const form = useForm({
                token: props.token,
                email: null,
                password: null,
                password_confirmation: null,
            });
            return { form };
        },

        methods: {
            resetPassword() {
                this.isLoading = true;

                this.form.post(route('password.update'), {
                    onError: () => {
                        this.isLoading = false;
                    },
                })
            }
        }
    }
</script>
