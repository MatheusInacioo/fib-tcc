<template>
    <BaseLayout>
        <Head title="Permissões"/>
        <div class="flex items-center justify-between">
            <div class="flex">
                <a
                    :href="route('settings.index')"
                >
                    <i class="bx bx-left-arrow-alt text-3xl hover:scale-110 transition-all mr-2"></i>
                </a>
                <span class="text-2xl mobile-std:text-xl font-medium">Permissões</span>
            </div>

            <button
                v-if="userIsAdmin"
                @click="toggleRoleModal()"
                class="flex justify-center items-center p-2 h-10 mobile-std:w-14 bg-primary rounded-xl text-secondary text-lg shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-briefcase mr-2 text-secondary mobile-std:mr-0"></i>
                <p class="mobile-std:hidden font-medium text-secondary">Cargos</p>
            </button>
        </div>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div
            v-for="role in roles"
            :key="role.id"
            class="w-full shadow-xl rounded-xl border border-gray-200 mb-4 flex flex-col"
        >
            <div class="rounded-t-xl h-[70px] p-4 flex items-center bg-primary">
                <span class="text-xl font-medium text-secondary">{{ role.name }}</span>
            </div>

            <div class="p-4 h-full overflow-x-auto scrollbar-thin">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 text-left">Permissão</th>
                            <th
                                class="py-2 px-4"
                                v-for="item in items"
                                :key="item"
                            >
                                {{ item.label }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="permission in permissions"
                            :key="permission.action"
                            class="hover:bg-gray-100 transition-all"
                        >
                            <td class="py-2 px-4">{{ permission.label }}</td>
                            <td
                                v-for="item in items"
                                :key="item"
                                class="py-2 px-4 text-center"
                            >
                                <input
                                    type="checkbox"
                                    class="rounded-lg"
                                    :class="{
                                        'hidden' : permission.action == 'edit' && item.subject == 'transactions' ||
                                                   permission.action == 'create' && item.subject == 'invoicing' ||
                                                   permission.action == 'edit' && item.subject == 'invoicing' ||
                                                   permission.action == 'delete' && item.subject == 'invoicing'
                                    }"
                                    :checked="hasPermission(role.id, item.subject, permission.action)"
                                    @change="togglePermission(role.id, item.subject, permission.action)"
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex mobile-std:justify-between">
            <a
                :href="route('settings.index')"
                class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-gray-400 hover:scale-105 transition-all"
            >
                Voltar
            </a>
            <button
                @click="savePermissions()"
                :disabled="isLoading"
                class="flex justify-center items-center w-24 2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
            >
                <span v-if="!isLoading">Salvar</span>
                <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-2xl"></i>
            </button>
        </div>

        <RoleModal
            :show-modal="showRoleModal"
            :roles="roles"
            @close-modal="toggleRoleModal()"
        />
    </BaseLayout>
</template>

<script>
    import { useForm, Head } from '@inertiajs/vue3';
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';
    import RoleModal from '@/Components/Utils/RoleModal.vue';

    export default {
        components: {
            Head,
            BaseLayout,
            RoleModal,
        },

        props: {
            roles: {},
        },

        setup() {
            const form = useForm({
                markedPermissions: [],
            });

            return { form }
        },

        data() {
            return {
                isLoading: false,
                showRoleModal: false,
                items: [
                   {
                        label: 'Faturamento',
                        subject: 'invoicing',
                   },
                   {
                        label: 'Transações',
                        subject: 'transactions',
                   },
                   {
                        label: 'Clientes',
                        subject: 'customers',
                   },
                   {
                        label: 'CRM',
                        subject: 'crm',
                   },
                   {
                        label: 'Fornecedores',
                        subject: 'suppliers',
                   },
                   {
                        label: 'Produtos',
                        subject: 'products',
                   },
                   {
                        label: 'Usuários',
                        subject: 'users',
                   },
                ],
                permissions: [
                   {
                        label: 'Listar',
                        action: 'list',
                   },
                   {
                        label: 'Exportar',
                        action: 'export',
                   },
                   {
                        label: 'Cadastrar',
                        action: 'create',
                   },
                   {
                        label: 'Editar',
                        action: 'edit',
                   },
                   {
                        label: 'Excluir',
                        action: 'delete',
                   },
                ],
            }
        },

        methods: {
            async fetchPermissions() {
                try {
                    const response = await axios.get(this.route('permissions.fetch'));

                    this.form.markedPermissions = response.data;
                } catch (error) {
                    console.error('Erro ao buscar permissões:', error);
                }
            },

            hasPermission(roleId, subject, action) {
                const permissionName = `${action}-${subject}`;

                return this.form.markedPermissions.some(p => p.role_id === roleId && p.name === permissionName);
            },

            togglePermission(roleId, subject, permission) {
                const permissionName = `${permission}-${subject}`;
                const existingPermissionIndex = this.form.markedPermissions.findIndex(p => p.role_id === roleId && p.name === permissionName);

                if (existingPermissionIndex !== -1) {
                    this.form.markedPermissions.splice(existingPermissionIndex, 1);
                } else {
                    this.form.markedPermissions.push({
                        role_id: roleId,
                        name: permissionName
                    });
                }
            },

            savePermissions() {
                try {
                    this.isLoading = true;

                    return this.form.post(route('permissions.store'), {
                        onError: () => {
                            this.isLoading = false;
                        },
                    });
                } catch (error) {
                    console.error('Erro ao salvar permissões: ', error)
                }
            },

            toggleRoleModal() {
                this.showRoleModal = ! this.showRoleModal;
            },
        },

        created() {
            this.fetchPermissions();
        },
    }
</script>
