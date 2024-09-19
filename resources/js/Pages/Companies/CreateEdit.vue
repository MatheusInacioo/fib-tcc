<template>
    <BaseLayout>
        <Head :title="pageTitle"/>
        <div class="flex items-center">
            <a
                :href="route('companies.index')"
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
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome fantasia da empresa</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome fantasia da empresa"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Razão Social</span>
                    <input
                        v-model="form.corporate_name"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="corporateName"
                        id="corporateName"
                        placeholder="Razão social da empresa"
                    >
                    <div v-if="form.errors.corporate_name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.corporate_name }}</div>
                </div>
            </div>

            <div class="flex mobile-std:justify-between">
                <a
                    :href="route('companies.index')"
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
        company: {},
    },

    setup() {
        const form = useForm({
            name: null,
            corporate_name: null,
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
            return this.company ? 'Editar Empresa' : 'Nova Empresa';
        },

        companyExists() {
            return this.company ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.companyExists ? this.updateCompany() : this.createCompany();
        },

        createCompany() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.post(route('companies.store'), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        updateCompany() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.put(route('companies.update', this.company.data.id), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.corporate_name = data.corporate_name;
        },
    },

    created() {
        if(this.companyExists) {
            this.buildForm(this.company.data);
        }
    },
}
</script>
