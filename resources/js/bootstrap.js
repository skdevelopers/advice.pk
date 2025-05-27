import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Auto-detect base URL (will work in any domain)
axios.defaults.baseURL = window.location.origin;

// Automatically attach CSRF token from meta tag
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
} else {
    console.error('CSRF token not found: Make sure <meta name="csrf-token" content="{{ csrf_token() }}"> is in your <head>');
}

// Optional: Authorization token (if needed)
const authToken = localStorage.getItem('token');
if (authToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
}

// Set JSON Content-Type for POST by default
axios.defaults.headers.post['Content-Type'] = 'application/json';

// Global error handler
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);