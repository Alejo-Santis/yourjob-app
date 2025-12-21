Para instalar Inertia.js con Svelte 5 en Laravel usando Vite, necesitas instalar los paquetes de **Inertia/Svelte**, configurar `vite.config.js` para **Svelte y Laravel**, inicializar Inertia en `app.js` 
para que use **Svelte**, y crear una plantilla `app.blade.php` básica que use `vite()` y `@inertia`.

Aquí están los pasos detallados:

1. **Instalación de Paquetes**
Instalar Laravel, Inertia.js, Svelte, Vite.
```bash

# Instalar adaptadores y dependencias de Inertia

composer require inertiajs/inertia-laravel

# Instalar Vite y Svelte

npm install -D @sveltejs/vite-plugin-svelte @inertiajs/inertia @inertiajs/svelte
```

2. **Configuración de Vite (vite.config.js)**
Asegúrate de que tu archivo `vite.config.js` incluya el plugin de Svelte y el plugin de Laravel, configurando los puntos de entrada correctos.
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte'; // <-- Añade esto

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js', // Tu punto de entrada principal
            ],
            refresh: true,
        }),
        svelte(), // <-- Añade esto
    ],
});
```

3. **Configuración del Lado del Cliente (`resources/js/app.js`)**
Inicializa Inertia con un componente raíz de Svelte.
```javascript
import { createInertiaApp } from '@inertiajs/inertia';
import { createSSRApp } from 'vue'; // Si usas SSR, si no, solo Inertia

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    resolve: name => {
        // Esto buscará componentes en resources/js/Pages
        return resolvePageComponent(`./Pages/${name}.svelte`, import.meta.glob('./Pages/**/*.svelte'));
    },
    setup({ el, App, props }) {
        new createSSRApp({
            render: () => h(App, props),
        }).mount(el);
    },
});
```

4. **Plantilla Raíz (`resources/views/app.blade.php`)**
Crea este archivo para renderizar tu aplicación.
```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
```

5. **Crea tu Primera Página**
Crea una carpeta `resources/js/Pages` y dentro, un componente Svelte, por ejemplo `Welcome.svelte`.
```bash
mkdir resources/js/Pages
touch resources/js/Pages/Welcome.svelte
```

6. **Ejecuta tu Aplicación**
```bash
npm run dev
php artisan serve
```

¡Ahora deberías poder ver tu aplicación Inertia.js con Svelte en acción!
