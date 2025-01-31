<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="updateUser">
            <input v-model="name" type="text" placeholder="Name" required />
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" />
            <input v-model="password_confirmation" type="password" placeholder="Confirm Password" />
            <button type="submit">Update User</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },
    data() {
        return {
            name: this.user.name,
            email: this.user.email,
            password: '',
            password_confirmation: '',
        };
    },
    methods: {
        async updateUser() {
            const data = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            await axios.put(`/users/${this.user.id}`, data);
            this.$inertia.visit('/users');
        },
    },
}
</script>
