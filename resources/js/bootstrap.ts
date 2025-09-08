
import axios from 'axios';

// Declaración global para extender la interfaz Window
// Esto le dice a TypeScript que 'axios' será una propiedad en el objeto global 'window'.
declare global {
    interface Window {
        axios: typeof axios; // 'typeof axios' se refiere al tipo del módulo axios que importamos
    }
}

// Asigna la instancia importada de axios al objeto global window
window.axios = axios;

// Configura una cabecera HTTP predeterminada para todas las peticiones de Axios
// Indica que la petición es una solicitud AJAX.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
