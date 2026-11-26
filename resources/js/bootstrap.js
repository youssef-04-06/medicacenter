import axios from 'axios';
window.axios = axios;
Codeium: Open Chat
Codeium

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

