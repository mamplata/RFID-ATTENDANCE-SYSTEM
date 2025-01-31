import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Make sure to load Pusher globally
window.Pusher = Pusher;

// Initialize Echo with Pusher
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // Correct way to access environment variable in Vite
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Correct way to access environment variable in Vite
    forceTLS: true,
});