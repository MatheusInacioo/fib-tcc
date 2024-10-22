export default {
    computed: {
        userPermissions() {
            return this.$page.props.auth.user.role.permissions.map(permission => permission.name) || [];
        },

        userRole() {
            return this.$page.props.auth.user.role.name;
        },

        userIsAdmin() {
            return this.$page.props.auth.user.role.name == 'Administrador';
        },
    },

    methods: {
        userHasPermission(action, subject) {
            const permission = `${action}-${subject}`;

            return this.userPermissions.includes(permission);
        },

        userHasRole(roleName) {
            return this.userRole.includes(roleName);
        },
    }
};
