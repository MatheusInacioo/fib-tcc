<template>
    <div>
        <Head title="Senha"/>
        <div class="login-screen w-screen h-screen flex justify-center items-center bg-[url('/img/app/background.jpg')] bg-center bg-cover font-roboto">
            <div class="mobile-std:h-full mobile-std:w-full w-[500px] shadow-2xl rounded-xl mobile-std:rounded-none bg-gray-800 bg-opacity-20 mobile-std:bg-white backdrop-filter backdrop-blur-xl flex flex-col justify-center p-4">
                <div class="flex flex-col justify-center items-center mb-10">
                    <img class="mobile-std:hidden" width="300" src="/img/app/logo/logo-bw.png" alt="logo">
                    <img class="web:hidden mobile-lg:hidden" width="300" src="/img/app/logo/logo.png" alt="logo">
                </div>

                <span class="text-secondary mobile-std:text-black mb-4">• Enviaremos um e-mail com um link para redefinir sua senha no endereço informado.</span>

                <span class="text-secondary mobile-std:text-black mb-4">• Certifique-se de verificar sua caixa de entrada e, se necessário, a pasta de spam ou lixo eletrônico.</span>

                <span class="text-secondary mobile-std:text-black">• O link será válido por 60 minutos. Se você não receber o e-mail, tente novamente ou entre em contato com o suporte.</span>

                <form
                    method="POST"
                    class="flex flex-col"
                    @submit.prevent="form.post(route('password.email'))"
                >
                    <div class="grid grid-cols-1 gap-4">

                        <span v-if="$page.props.errors" class="text-red-500 text-base font-semibold">{{ $page.props.errors.error }}</span>
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

                        <button
                            type="submit"
                            class="flex justify-center items-center w-full h-10 bg-primary rounded-xl text-secondary text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <span>Enviar</span>
                        </button>

                        <a
                            :href="route('login')"
                            class="flex justify-center items-center text-secondary mobile-std:text-primary text-sm font-medium mt-2"
                        >
                            Voltar
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
            })

            return { form }
        },
    }
</script>
