<template>
    <BaseLayout>
        <Head :title="pageTitle"/>
        <div class="flex items-center">
            <a
                :href="route('shops.index')"
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
            <div class="form-row grid grid-cols-4 mobile-std:grid-cols-1 mobile-lg:grid-cols-3 gap-4 mb-4">
                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome da loja</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome da loja"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                </div>

                <div
                    class="form-field flex flex-col"
                    :class="{ 'hidden' : companies.length <= 1 }"
                >
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Empresa</span>
                    <select
                        v-model="form.company_id"
                        name="company"
                        id="company"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="company in companies"
                            :key="company.id"
                            :value="company.id"
                        >
                            {{ company.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.company_id" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.company_id }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Localização</span>
                    <input
                        v-model="form.location"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="location"
                        id="location"
                        placeholder="Localização da loja"
                    >
                    <div v-if="form.errors.location" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.location }}</div>
                </div>
            </div>

            <div class="flex mobile-std:justify-between">
                <a
                    :href="route('shops.index')"
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
        shop: {},
        companies: {},
    },

    setup() {
        const form = useForm({
            name: null,
            location: null,
            company_id: null,
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
            return this.shop ? 'Editar Loja' : 'Nova Loja';
        },

        shopExists() {
            return this.shop ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.shopExists ? this.updateshop() : this.createshop();
        },

        createshop() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.post(route('shops.store'), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        updateshop() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.put(route('shops.update', this.shop.data.id), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.location = data.location;
            this.form.company_id = data.company_id;
        },
    },

    created() {
        if(this.shopExists) {
            this.buildForm(this.shop.data);
        }
    },
}
</script>
