<template>
    <div>
        <h1>Users List</h1>
        <ul>
            <li v-for="user in users" :key="user.id">
                {{ user.name }} - {{ user.email }}
                <!-- Use Inertia's Link component -->
                <Link :href="`/users/${user.id}/edit`">Edit</Link>
                <button @click="deleteUser(user.id)">Delete</button>
            </li>
        </ul>
        <Link href="/users/create">Create New User</Link>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    props: {
        users: Array,
    },
    methods: {
        async deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                await axios.delete(`/users/${id}`);
                this.$inertia.reload();
            }
        },
    },
}
</script>
