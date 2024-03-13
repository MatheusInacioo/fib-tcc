<template>
    <div>
        <div class="login-screen w-screen h-screen flex justify-start bg-[url('img/app/background.jpg')] bg-center bg-cover">
            <div class="h-full w-500 shadow-2xl bg-gray-50 bg-opacity-50 backdrop-filter backdrop-blur-md flex flex-col justify-center p-10">
                <h4 class="text-4xl font-bold text-orange-400 mb-20 text-center">LOGIN</h4>

                <form
                    method="POST"
                    class="flex flex-col"
                    @submit.prevent="form.post(route('login.store'))"
                >
                    <span v-if="$page.props.errors" class="text-red-500 text-lg font-bold">{{ $page.props.errors.error }}</span>
                    <div class="flex flex-col mb-3">
                        <label class="text-xl font-bold mb-2 text-orange-500">Email</label>
                        <input
                            v-model="form.email"
                            class="h-12 text-base rounded-2xl bg-transparent border-black hover:border-orange-500 focus:border-none transition-all"
                            type="text"
                            name="email"
                            placeholder="Digite seu email..."
                        >
                        <span v-if="form.errors.email" class="text-red-500 text-lg font-bold">{{ form.errors.email }}</span>
                    </div>

                    <div class="flex flex-col mb-3">
                        <label class="text-xl font-bold mb-2 text-orange-500">Senha</label>
                        <div class="flex border border-black rounded-2xl hover:border-orange-500 focus:border-orange-500 transition-all">
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
                                    :class="{'bx bx-hide' : showPassword, 'bx bx-show': !showPassword}"
                                ></i>
                            </button>
                        </div>
                        <span v-if="form.errors.password" class="text-red-500 text-lg font-bold mb-3">{{ form.errors.password }}</span>
                    </div>
                    <div class="flex items-center">
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            class="bg-transparent rounded-md mr-2 outline-none"
                            name="remember"
                        >
                        <span class="font-bold text-base text-orange-500">Lembrar de mim</span>
                    </div>

                    <button
                        type="submit"
                        class="w-full h-10 mt-10 bg-orange-400 rounded-2xl text-white text-lg font-bold shadow-xl"
                    >
                        Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

    export default {
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
