<template>
    <div>
        <Head title="Login"/>
        <div class="login-screen w-screen h-screen flex bg-[url('img/app/background.jpg')] bg-center bg-cover">
            <div class="h-full mobile-std:w-full w-[500px] shadow-2xl bg-gray-800 bg-opacity-20 mobile-std:bg-white backdrop-filter backdrop-blur-xl flex flex-col justify-center p-4">
                <div class="flex flex-col justify-center items-center mb-[50px]">
                    <img class="mobile-std:hidden" width="300" src="/img/app/logo/logo-bw.png" alt="logo">
                    <img class="web:hidden mobile-lg:hidden" width="300" src="/img/app/logo/logo.png" alt="logo">
                </div>

                <form
                    method="POST"
                    class="flex flex-col font-roboto"
                    @submit.prevent="login()"
                >
                    <div class="grid grid-cols-1 gap-4">

                        <span v-if="$page.props.errors" class="text-red-500 text-base font-semibold">{{ $page.props.errors.error }}</span>
                        <div class="flex flex-col">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Email</label>
                            <input
                                v-model="form.email"
                                class="h-12 rounded-xl bg-transparent border-gray-500 mobile-std:border-primary hover:border-secondary focus:border-secondary transition-all text-secondary mobile-std:text-black"
                                type="text"
                                name="email"
                                placeholder="Digite seu email..."
                            >
                            <span v-if="form.errors.email" class="text-red-500 text-base font-semibold">{{ form.errors.email }}</span>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Senha</label>
                            <div class="flex border border-gray-500 mobile-std:border-primary rounded-xl hover:border-secondary focus:border-secondary transition-all">
                                <input
                                    v-model="form.password"
                                    class="w-full h-12 rounded-l-xl bg-transparent border-none outline-none text-secondary mobile-std:text-black"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Digite sua senha..."
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
                            <span v-if="form.errors.password" class="text-red-500 text-base font-semibold mb-3">{{ form.errors.password }}</span>
                        </div>

                        <div class="flex items-center">
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="bg-transparent rounded-md mr-2 outline-none"
                                name="remember"
                            >
                            <span class="font-semibold text-secondary mobile-std:text-primary">Lembrar de mim</span>
                        </div>

                        <button
                            type="submit"
                            class="flex justify-center items-center w-full h-10 bg-primary rounded-xl text-secondary text-lg font-roboto font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <div
                                v-if="!isLoading"
                                class="flex justify-center items-center h-full w-full"
                            >
                                <i class="bx bx-log-in mr-2 font-medium"></i>
                                <span>Entrar</span>
                            </div>

                            <i
                                v-if="isLoading"
                                class="bx bx-loader-alt animate-spin text-3xl"
                            ></i>
                        </button>

                        <a
                            :href="route('login.recover')"
                            class="flex justify-center items-center text-secondary mobile-std:text-primary text-sm font-medium mt-4"
                        >
                            Esqueceu sua senha?
                        </a>
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

        setup() {
            const form = useForm({
                email: null,
                password: null,
                remember: null,
            })

            return { form }
        },

        data() {
            return {
                isLoading: false,
                showPassword: false,
            }
        },

        methods: {
            login() {
                this.form.clearErrors();
                this.isLoading = true;

                this.form.post(route('login.store'), {
                    onError: () => {
                        this.isLoading = false;
                    }
                });
            }
        },
    }
</script>
