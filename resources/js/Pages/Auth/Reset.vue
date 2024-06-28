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
                    @submit.prevent="form.post(route('password.update'))"
                >
                    <div class="grid grid-cols-1 gap-4">
                        <input type="hidden" name="token" :value="form.token">
                        <div class="flex flex-col mb-4">
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
                        <div class="flex flex-col mb-4">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Nova Senha</label>
                            <input
                                v-model="form.password"
                                class="h-12 rounded-xl bg-transparent border-gray-500 mobile-std:border-primary hover:border-secondary focus:border-secondary transition-all text-secondary mobile-std:text-black"
                                type="password"
                                name="password"
                                placeholder="Digite sua nova senha..."
                            >
                            <span v-if="form.errors.password" class="text-red-500 text-base font-semibold">{{ form.errors.password }}</span>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label class="text-lg font-semibold mb-2 text-secondary mobile-std:text-primary">Confirme a Nova Senha</label>
                            <input
                                v-model="form.password_confirmation"
                                class="h-12 rounded-xl bg-transparent border-gray-500 mobile-std:border-primary hover:border-secondary focus:border-secondary transition-all text-secondary mobile-std:text-black"
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirme sua nova senha..."
                            >
                            <span v-if="form.errors.password_confirmation" class="text-red-500 text-base font-semibold">{{ form.errors.password_confirmation }}</span>
                        </div>
                        <button
                            type="submit"
                            class="flex justify-center items-center w-full h-10 bg-primary rounded-xl text-secondary text-lg font-medium shadow-xl hover:scale-105 transition-all"
                        >
                            <span>Redefinir Senha</span>
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

        setup(props) {
            const form = useForm({
                token: props.token,
                email: null,
                password: null,
                password_confirmation: null,
            });
            return { form };
        },
    }
</script>
