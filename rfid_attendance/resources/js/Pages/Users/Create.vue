<template>
    <div>
        <h1>Create User</h1>
        <form @submit.prevent="createUser">
            <input v-model="name" type="text" placeholder="Name" required />
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required />
            <button type="submit">Create User</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        };
    },
    methods: {
        async createUser() {
            const data = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            await axios.post('/users', data);
            this.$inertia.visit('/users');
        },
    },
}
</script>
