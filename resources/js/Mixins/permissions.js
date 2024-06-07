export default {
    computed: {
        userPermissions() {
            return this.$page.props.auth.user.role.permissions.map(permission => permission.name) || [];
        }
    },

    methods: {
        userHasPermission(action, subject) {
            const permission = `${action}-${subject}`;

            return this.userPermissions.includes(permission);
        }
    }
};
