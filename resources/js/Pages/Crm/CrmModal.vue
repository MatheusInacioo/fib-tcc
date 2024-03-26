<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="confirmation-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center h-[80%] px-4 w-[50%]"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-full p-4 flex flex-col"
                    >
                        <div class="flex justify-between w-full items-center">
                            <p class="2xl:text-2xl text-xl font-medium">{{ modalTitle }}</p>
                            <button
                                class="2xl:w-8 2xl:h-8 bg-transparent border-none text-primary 2xl:text-4xl hover:scale-125 transition-all flex justify-center items-center"
                                @click="closeModal()"
                            >
                                <i class="bx bx-x"></i>
                            </button>
                        </div>

                        <div class="w-full h-px bg-primary my-4"></div>

                        <div class="h-full overflow-y-auto scrollbar-thin">
                            <form class="w-full">
                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Nome da empresa</span>
                                        <input
                                            v-model="form.name"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
                                            type="text"
                                            name="name"
                                            id="name"
                                            placeholder="Nome fantasia da empresa"
                                        >
                                        <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">CNPJ</span>
                                        <input
                                            v-model="form.cnpj"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
                                            type="text"
                                            name="cnpj"
                                            id="cnpj"
                                            v-maska
                                            data-maska="##.###.###/0001-##"
                                            placeholder="00.000.000/0001-00"
                                        >
                                        <div v-if="form.errors.cnpj" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.cnpj }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Email da empresa</span>
                                        <input
                                            v-model="form.email"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
                                            type="email"
                                            name="email"
                                            id="email"
                                            placeholder="Ex: email@email.com"
                                        >
                                        <div v-if="form.errors.email" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.email }}</div>
                                    </div>
                                </div>

                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4 w-full">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Endereço da empresa</span>
                                        <input
                                            v-model="form.address"
                                            class="border-gray-300 2xl:text-base text-sm rounded-lg"
                                            type="text"
                                            name="address"
                                            id="address"
                                            placeholder="Endereço da empresa"
                                        >
                                        <div v-if="form.errors.address" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.address }}</div>
                                    </div>
                                </div>

                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Telefone da empresa</span>
                                        <input
                                            v-model="form.phone"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
                                            type="text"
                                            name="phone"
                                            id="phone"
                                            v-maska
                                            data-maska="(##)####-####"
                                            placeholder="(00)0000-0000"
                                        >
                                        <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.phone }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Nome do responsável</span>
                                        <input
                                            v-model="form.responsible"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
                                            type="text"
                                            name="responsible"
                                            id="responsible"
                                            placeholder="Nome do responsável pela empresa"
                                        >
                                        <div v-if="form.errors.responsible" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Celular do responsável</span>
                                        <input
                                            v-model="form.responsible_phone"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
                                            type="text"
                                            name="responsible-phone"
                                            id="responsible-phone"
                                            v-maska
                                            data-maska="(##)#####-####"
                                            placeholder="(00)00000-0000"
                                        >
                                        <div v-if="form.errors.responsible_phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible_phone }}</div>
                                    </div>
                                </div>

                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Segmento de atuação</span>
                                        <select
                                            v-model="form.segment"
                                            name="segment"
                                            id="segment"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
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

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Tipo de Cadastro</span>
                                        <select
                                            v-model="form.type"
                                            name="type"
                                            id="type"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
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

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Status</span>
                                        <select
                                            v-model="form.status"
                                            name="status"
                                            id="status"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-lg"
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
                                </div>

                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col w-full">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Descrição</span>
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
                            </form>

                            <div
                                v-if="item.attendances"
                                class="w-full flex flex-col"
                            >
                                <p class="font-medium text-xl mb-4">Histórico de Atendimento</p>
                                <div
                                    v-for="attendance in item.attendances"
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

                        <div class="flex justify-between w-full items-center pt-4">
                            <button
                                type="button"
                                class="2xl:h-10 w-24 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base bg-gray-400 hover:scale-105 transition-all"
                                @click="closeModal()"
                            >
                                Cancelar
                            </button>
                            <button
                                @click="saveForm()"
                                class="2xl:h-10 w-24 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
                            >
                                Salvar
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import { vMaska } from "maska";

export default {
    directives: { maska: vMaska },

    props: {
        item: {
            type: Object,
            default: () => ({}),
        },

        showModal: {
            type: Boolean,
            default: false,
        },
    },

    setup() {
        const form = useForm({
            name: null,
            cnpj: null,
            email: null,
            address: null,
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
            types: [
                'Cliente',
                'Fornecedor',
                'Distribuidor',
            ],

            statuses: [
                'Contato',
                'Negociação',
                'Assinatura Pendente',
                'Standby',
                'Sem Interesse',
            ],

            segments: [
                'Atacado',
                'Varejo',
                'Transportes',
                'Distribuidora',
                'Alimentação',
            ],
        }
    },

    computed: {
        modalTitle() {
            return this.itemExists ? 'Editar Cadastro' : 'Novo Cadastro';
        },

        itemExists() {
            return this.item.id ? true : false;
        },
    },

    methods: {
        closeModal() {
            this.$emit('close-modal');
        },

        saveForm() {
            this.itemExists ? this.updateCrm() : this.createCrm();

            this.closeModal();
        },

        createCrm() {
            return this.form.post(route('crm.store'));
        },

        updateCrm() {
            return this.form.put(route('crm.update', this.item.data.id));
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.cnpj = data.cnpj;
            this.form.email = data.email;
            this.form.address = data.address;
            this.form.phone = data.phone;
            this.form.responsible = data.responsible;
            this.form.responsible_phone = data.responsible_phone;
            this.form.segment = data.segment;
            this.form.type = data.type;
            this.form.status = data.status;
            this.form.description = data.description;
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
    },

    created() {
        if (this.itemExists && this.showModal) {
            this.buildForm(this.item);
        }
    }
};
</script>

<style scoped>
    .modal-overlay-enter-active,
    .modal-overlay-leave-active {
        transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-overlay-enter-from,
    .modal-overlay-leave-to {
        opacity: 0;
    }

    .modal-body-enter-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
    }

    .modal-body-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-body-enter-from {
        opacity: 0;
        transform: scale(0.8);
    }

    .modal-body-leave-to {
        transform: scale(0.8);
    }
</style>
