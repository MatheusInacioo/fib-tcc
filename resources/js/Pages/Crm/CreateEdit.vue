<template>
    <BaseLayout>
        <Head :title="'CRM - ' + pageTitle"/>
        <div class="flex items-center">
            <a
                :href="route('crm.index')"
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
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome da empresa</span>
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
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">CNPJ</span>
                    <input
                        v-model="form.cnpj"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="cnpj"
                        id="cnpj"
                        v-maska
                        data-maska="##.###.###/0001-##"
                        placeholder="00.000.000/0001-00"
                    >
                    <div v-if="form.errors.cnpj" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.cnpj }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Email da empresa</span>
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
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Telefone da empresa</span>
                    <input
                        v-model="form.phone"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="phone"
                        id="phone"
                        v-maska
                        data-maska="(##)####-####"
                        placeholder="(00)0000-0000"
                    >
                    <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.phone }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Endereço da empresa</span>
                    <input
                        v-model="form.address"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="address"
                        id="address"
                        placeholder="Endereço da empresa"
                    >
                    <div v-if="form.errors.address" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.address }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">CEP</span>
                    <input
                        v-model="form.zip_code"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="zip-code"
                        id="zip-code"
                        v-maska
                        data-maska="#####-###"
                        placeholder="00000-000"
                    >
                    <div v-if="form.errors.zip_code" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.zip_code }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome do responsável</span>
                    <input
                        v-model="form.responsible"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="responsible"
                        id="responsible"
                        placeholder="Nome do responsável pela empresa"
                    >
                    <div v-if="form.errors.responsible" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Celular do responsável</span>
                    <input
                        v-model="form.responsible_phone"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="responsible-phone"
                        id="responsible-phone"
                        v-maska
                        data-maska="(##)#####-####"
                        placeholder="(00)00000-0000"
                    >
                    <div v-if="form.errors.responsible_phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible_phone }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Segmento de atuação</span>
                    <select
                        v-model="form.segment"
                        name="segment"
                        id="segment"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="segment in segments"
                            :key="segment.id"
                            :value="segment"
                        >
                            {{ segment }}
                        </option>
                    </select>
                    <div v-if="form.errors.segment" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.segment }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Tipo de Cadastro</span>
                    <select
                        v-model="form.type"
                        name="type"
                        id="type"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="type in types"
                            :key="type.id"
                            :value="type"
                        >
                            {{ type }}
                        </option>
                    </select>
                    <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.type }}</div>
                </div>

                <div class="form-field flex flex-col">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Status</span>
                    <select
                        v-model="form.status"
                        name="status"
                        id="status"
                        class="border-gray-300 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="status in statuses"
                            :key="status.id"
                            :value="status"
                        >
                            {{ status }}
                        </option>
                    </select>
                    <div v-if="form.errors.status" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.status }}</div>
                </div>

                <button
                    v-if="itemExists"
                    @click="toggleConfirmationModal()"
                    type="button"
                    class="flex justify-center items-center mt-8 mobile-std:mt-0 p-2 h-10 w-[160px] bg-primary text-secondary rounded-xl shadow-xl hover:scale-105 transition-all self-center"
                >
                    <i class="bx bx-task mr-2"></i>
                    <p class="font-medium">Fechar Contrato</p>
                </button>
            </div>

            <div class="form-row flex mb-4 mobile-std:flex-col mobile-std:mb-2">
                <div class="form-field flex flex-col w-full">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Descrição</span>
                    <textarea
                        v-model="form.description"
                        class="border-gray-300 h-[150px] w-full 2xl:text-base text-sm rounded-lg"
                        name="description"
                        id="description"
                        maxlength="500"
                        placeholder="Descrição sobre o atendimento (máx. 500 caracteres)"
                    ></textarea>
                    <div v-if="form.errors.description" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.description }}</div>
                </div>
            </div>

            <div
                v-if="item.data.attendances.length > 0"
                class="w-full flex flex-col"
            >
                <p class="font-medium text-xl mb-4">Histórico de Atendimento</p>
                <div class="max-h-[200px] overflow-y-auto scrollbar-thin">
                    <div
                        v-for="attendance in item.data.attendances"
                        :key="attendance.id"
                        class="flex w-full mb-4"
                    >
                        <i class="bx bx-message-dots text-primary text-2xl mr-2"></i>
                        <div class="flex flex-col">
                            <p class="text-gray-400 mb-2 text-base">{{ formatAttendanceDate(attendance.created_at) + ' - ' + attendance.user }}</p>
                            <p class="text-base italic">{{ attendance.description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex mobile-std:justify-between">
                <a
                    :href="route('crm.index')"
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

        <ConfirmationModal
            :show-modal="showModal"
            :custom-message="message"
            @close-contract="closeContract()"
            @close-modal="toggleConfirmationModal()"
        />
    </BaseLayout>
</template>

<script>
import ConfirmationModal from '@/Components/Utils/ConfirmationModal.vue';
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { vMaska } from "maska"

export default {
    directives: { maska: vMaska },

    components: {
        Head,
        BaseLayout,
        ConfirmationModal,
    },

    props: {
        item: {
            type: Object,
            default: () => ({}),
        },
    },

    setup() {
        const form = useForm({
            name: null,
            cnpj: null,
            email: null,
            address: null,
            zip_code: null,
            phone: null,
            responsible: null,
            responsible_phone: null,
            segment: null,
            type: null,
            status: null,
            description: null,
        });

        return { form }
    },

    data() {
        return {
            isLoading: false,
            showModal: false,
            message: {
                content: '',
                subject: 'close-contract',
            },
            types: ['Cliente', 'Fornecedor'],
            statuses: [
                'Contato',
                'Negociação',
                'Assinatura Pendente',
                'Standby',
                'Sem Interesse',
            ],
            segments: [
                'Alimentação',
                'Atacado',
                'Distribuidora',
                'Transportes',
                'Varejo',
            ],
        }
    },

    computed: {
        pageTitle() {
            return this.itemExists ? 'Editar Cadastro' : 'Novo Cadastro';
        },

        itemExists() {
            return this.item.data.id ? true : false;
        }
    },

    methods: {
        saveForm() {
            this.itemExists ? this.updateCrm() : this.createCrm();
        },

        createCrm() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.post(route('crm.store'), {
                onError: () => {
                    this.isLoading = false;
                },
            });
        },

        updateCrm() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.put(route('crm.update', this.item.data.id), {
                onError: () => {
                    this.isLoading = false;
                },
            });
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.cnpj = data.cnpj;
            this.form.email = data.email;
            this.form.address = data.address;
            this.form.zip_code = data.zip_code;
            this.form.phone = data.phone;
            this.form.responsible = data.responsible;
            this.form.responsible_phone = data.responsible_phone;
            this.form.segment = data.segment;
            this.form.type = data.type;
            this.form.status = data.status;
            this.form.description = null;
        },

        formatAttendanceDate(dateString) {
            const date = new Date(dateString);

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${day}/${month}/${year} às ${hours}:${minutes}`;
        },

        closeContract() {
            try {
                this.form.post(route('crm.close', this.item.data.id));

                this.toggleConfirmationModal();
            } catch (error) {
                console.error(error);
            }
        },

        toggleConfirmationModal() {
            this.message.content = `Ao clicar em confirmar, o atendimento #${this.item.data.id} será encerrado e cadastrado como <span class="uppercase font-bold">${this.form.type}</span>. <br/> Deseja continuar?`;

            this.showModal = ! this.showModal;
        },
    },

    created() {
        if(this.itemExists) {
            this.buildForm(this.item.data);
        }
    },
}
</script>
