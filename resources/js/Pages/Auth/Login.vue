<template>
    <div>
        <Head title="Login"/>
        <div class="login-screen w-screen h-screen flex justify-start bg-[url('img/app/background.jpg')] bg-center bg-cover">
            <div class="h-full mobile-std:w-full w-[500px] shadow-2xl bg-gray-50 bg-opacity-50 mobile-std:bg-opacity-100 backdrop-filter backdrop-blur-md flex flex-col justify-center p-10">
                <h4 class="text-4xl font-bold text-primary mb-20 text-center">LOGIN</h4>

                <form
                    method="POST"
                    class="flex flex-col font-poppins"
                    @submit.prevent="form.post(route('login.store'))"
                >
                    <span v-if="$page.props.errors" class="text-red-500 text-base font-semibold">{{ $page.props.errors.error }}</span>
                    <div class="flex flex-col mb-3">
                        <label class="text-xl font-semibold mb-2 text-primary">Email</label>
                        <input
                            v-model="form.email"
                            class="h-12 text-base rounded-2xl bg-transparent border-black hover:border-primary focus:border-none transition-all"
                            type="text"
                            name="email"
                            placeholder="Digite seu email..."
                        >
                        <span v-if="form.errors.email" class="text-red-500 text-base font-semibold">{{ form.errors.email }}</span>
                    </div>

                    <div class="flex flex-col mb-3">
                        <label class="text-xl font-semibold mb-2 text-primary">Senha</label>
                        <div class="flex border border-black rounded-2xl hover:border-primary focus:border-primary transition-all">
                            <input
                                v-model="form.password"
                                class="w-full h-12 text-base rounded-l-2xl bg-transparent border-none outline-none"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                placeholder="Digite sua senha..."
                            >
                            <button
                                type="button"
                                @click="showPassword = !showPassword">
                                <i
                                    class="text-xl w-10"
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
                        <span class="text-base font-semibold text-primary">Lembrar de mim</span>
                    </div>

                    <button
                        type="submit"
                        class="w-full h-10 mt-10 bg-primary rounded-2xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
                    >
                        Entrar
                    </button>
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
                showPassword: false,
            }
        }
    }
</script>
