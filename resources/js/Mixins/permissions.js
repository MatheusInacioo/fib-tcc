export default {
    computed: {
        userPermissions() {
            return this.$page.props.auth.user.role.permissions.map(permission => permission.name) || [];
        },

        userIsAdmin() {
            return this.$page.props.auth.user.role.name == 'Administrador';
        },

        userIsFinancial() {
            return this.$page.props.auth.user.role.name == 'Financeiro';
        },

        userIsSupport() {
            return this.$page.props.auth.user.role.name == 'Suporte';
        },
    },

    methods: {
        userHasPermission(action, subject) {
            const permission = `${action}-${subject}`;

            return this.userPermissions.includes(permission);
        },
    }
};
