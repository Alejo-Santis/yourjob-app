# 🎯 YourJob - Plataforma de Emparejamiento de Recursos Humanos

Una aplicación moderna de emparejamiento entre demandantes de empleo y empleadores, construida con Laravel 11, Svelte 5, Bootstrap 5.3 e Inertia.js.

## 📋 Tabla de Contenidos

- [Características](#características)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Base de Datos](#base-de-datos)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Enums](#enums)
- [Servicios](#servicios)
- [Controladores](#controladores)
- [Modelos](#modelos)
- [Frontend](#frontend)
- [API Endpoints](#api-endpoints)

## ✨ Características

### Para Demandantes de Empleo
- ✅ Registro y perfiles personalizados
- ✅ Carga de CV
- ✅ Gestión de habilidades y experiencia laboral
- ✅ Búsqueda avanzada de empleos
- ✅ Sistema de emparejamiento inteligente (Match Score 0-100)
- ✅ Guardar empleos favoritos
- ✅ Enviar solicitudes de empleo
- ✅ Ver estado de solicitudes
- ✅ Dashboard con recomendaciones personalizadas

### Para Empleadores
- ✅ Registro y perfiles de empresas
- ✅ Publicar ofertas de empleo
- ✅ Gestionar descripciones de puestos
- ✅ Recibir y gestionar solicitudes
- ✅ Aceptar/Rechazar candidatos
- ✅ Ver análisis de solicitudes
- ✅ Dashboard ejecutivo con estadísticas
- ✅ Sistema de verificación de empleadores

### Administrativas
- ✅ Gestión de usuarios
- ✅ Control de roles y permisos (Spatie)
- ✅ Moderar contenido
- ✅ Ver estadísticas del sistema

## 🔧 Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 16
- npm o yarn
- MySQL >= 8.0
- Git

## 📦 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/usuario/yourjob-app.git
cd yourjob-app
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar archivo .env
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la base de datos en .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourjob_app
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Ejecutar migraciones
```bash
php artisan migrate
```

### 7. Ejecutar seeders
```bash
php artisan db:seed
```

### 8. Compilar assets
```bash
npm run dev    # Desarrollo
npm run build  # Producción
```

### 9. Iniciar servidor
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 🗄️ Base de Datos

### Migraciones

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios del sistema (demandantes, empleadores, admins) |
| `job_seeker_profiles` | Perfiles de demandantes de empleo |
| `work_experiences` | Experiencia laboral de demandantes |
| `employer_profiles` | Perfiles de empleadores |
| `job_listings` | Ofertas de empleo |
| `applications` | Solicitudes de empleo |
| `favorites` | Empleos favoritos |
| `job_matches` | Puntuaciones de emparejamiento |
| `permissions` | Permisos del sistema |
| `roles` | Roles del sistema |
| `role_has_permissions` | Relación roles-permisos |

## 📁 Estructura del Proyecto

```
yourjob-app/
├── app/
│   ├── Enums/                    # Enumeraciones
│   │   ├── UserType.php
│   │   ├── ContractType.php
│   │   ├── WorkMode.php
│   │   ├── ApplicationStatus.php
│   │   ├── JobListingStatus.php
│   │   ├── Gender.php
│   │   └── IdentificationType.php
│   ├── Models/                   # Modelos Eloquent
│   │   ├── User.php
│   │   ├── JobSeekerProfile.php
│   │   ├── WorkExperience.php
│   │   ├── EmployerProfile.php
│   │   ├── JobListing.php
│   │   ├── Application.php
│   │   ├── Favorite.php
│   │   └── JobMatch.php
│   ├── Services/                 # Servicios de lógica de negocio
│   │   ├── JobMatchingService.php
│   │   ├── JobListingService.php
│   │   ├── ApplicationService.php
│   │   ├── JobSeekerService.php
│   │   └── EmployerService.php
│   ├── Http/
│   │   ├── Controllers/          # Controladores
│   │   │   ├── JobListingController.php
│   │   │   ├── ApplicationController.php
│   │   │   ├── JobSeekerProfileController.php
│   │   │   ├── EmployerProfileController.php
│   │   │   └── FavoriteController.php
│   │   └── Middleware/
│   └── Policies/                 # Políticas de autorización
│       ├── JobListingPolicy.php
│       └── ApplicationPolicy.php
├── database/
│   ├── migrations/               # Migraciones de BD
│   └── seeders/                  # Seeds
│       ├── PermissionSeeder.php
│       ├── UserSeeder.php
│       ├── JobListingSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── js/
│   │   ├── Layouts/              # Layouts Svelte
│   │   │   ├── AppLayout.svelte
│   │   │   ├── Navigation.svelte
│   │   │   ├── Sidebar.svelte
│   │   │   └── Footer.svelte
│   │   ├── Components/           # Componentes Svelte
│   │   │   ├── JobCard.svelte
│   │   │   ├── StatsCard.svelte
│   │   │   ├── Alert.svelte
│   │   │   ├── Toast.svelte
│   │   │   └── Form.svelte
│   │   └── Pages/                # Páginas (rutas)
│   └── css/                      # Estilos
│       └── app.css
└── routes/
    └── web.php                   # Rutas web
```

## 🏷️ Enums

### UserType
Define los tipos de usuarios en el sistema:
- `JOB_SEEKER` - Demandante de empleo
- `EMPLOYER` - Empleador
- `ADMIN` - Administrador

**Métodos útiles:**
```php
$user->user_type->label()        // "Job Seeker"
$user->user_type->color()        // "info"
UserType::choices()              // Array de opciones
```

### ContractType
Tipos de contrato:
- `FULL_TIME` - Tiempo completo
- `PART_TIME` - Tiempo parcial
- `FREELANCE` - Freelance
- `INTERNSHIP` - Prácticas
- `TEMPORARY` - Temporal
- `CONTRACT` - Contrato

### WorkMode
Modalidades de trabajo:
- `ON_SITE` - Presencial
- `REMOTE` - Remoto
- `HYBRID` - Híbrido

### ApplicationStatus
Estados de aplicación:
- `PENDING` - Pendiente
- `ACCEPTED` - Aceptada
- `REJECTED` - Rechazada
- `WITHDRAWN` - Retirada
- `UNDER_REVIEW` - En revisión

### JobListingStatus
Estados de ofertas:
- `DRAFT` - Borrador
- `ACTIVE` - Activa
- `CLOSED` - Cerrada
- `FILLED` - Ocupada
- `ARCHIVED` - Archivada

## 🔧 Servicios

### JobMatchingService
Servicio de emparejamiento inteligente.

**Métodos principales:**
```php
// Calcular puntuación de emparejamiento (0-100)
$score = $service->calculateMatch($seeker, $listing);

// Encontrar mejores coincidencias para un demandante
$matches = $service->findBestMatches($seeker, limit: 10, minScore: 50);

// Crear o actualizar registro de emparejamiento
$match = $service->createOrUpdateMatch($seeker, $listing);

// Generar todos los emparejamientos para un demandante
$service->generateAllMatches($seeker);
```

**Componentes de puntuación:**
- 40% - Coincidencia de habilidades
- 25% - Coincidencia de experiencia
- 20% - Coincidencia de ubicación
- 15% - Coincidencia de salario

### JobListingService
Gestión de ofertas de empleo.

**Métodos principales:**
```php
// Crear nueva oferta
$job = $service->create($employer, $data);

// Publicar oferta
$service->publish($listing, $data);

// Cerrar oferta
$service->close($listing, reason: 'filled');

// Búsqueda avanzada
$jobs = $service->search([
    'title' => 'Developer',
    'work_mode' => 'remote',
    'city' => 'New York',
    'salary_min' => 60000,
]);

// Estadísticas del empleador
$stats = $service->getEmployerStats($employer);
```

### ApplicationService
Gestión de solicitudes de empleo.

**Métodos principales:**
```php
// Crear aplicación
$app = $service->create($seeker, $listing, $data);

// Aceptar/Rechazar
$service->accept($application, 'message');
$service->reject($application, 'message');

// Retirar solicitud
$service->withdraw($application);

// Marcar como visto
$service->markAsViewed($application);

// Estadísticas
$stats = $service->getStatistics($listing);
```

### JobSeekerService
Gestión de perfiles de demandantes.

**Métodos principales:**
```php
// Crear perfil
$profile = $service->create($user, $data);

// Actualizar perfil
$service->update($profile, $data);

// Cargar CV
$path = $service->uploadCV($profile, $file);

// Gestionar habilidades
$service->addSkills($profile, ['PHP', 'Laravel']);
$service->removeSkill($profile, 'PHP');

// Obtener empleos recomendados
$jobs = $service->getRecommendedJobs($profile, limit: 10);
```

### EmployerService
Gestión de perfiles de empleadores.

**Métodos principales:**
```php
// Crear perfil
$profile = $service->create($user, $data);

// Actualizar perfil
$service->update($profile, $data);

// Cargar logo
$path = $service->uploadLogo($profile, $file);

// Verificar empleador
$service->verify($profile, 'notes');

// Obtener estadísticas
$stats = $service->getStatistics($profile);

// Aplicaciones recientes
$apps = $service->getRecentApplications($profile);
```

## 🎮 Controladores

### JobListingController
Gestión de ofertas de empleo.

**Rutas:**
- `GET /jobs` - Listar empleos
- `GET /jobs/{id}` - Ver detalle de empleo
- `GET /jobs/create` - Crear nueva oferta
- `POST /jobs` - Guardar nueva oferta
- `GET /jobs/{id}/edit` - Editar oferta
- `PUT /jobs/{id}` - Actualizar oferta
- `POST /jobs/{id}/publish` - Publicar oferta
- `POST /jobs/{id}/close` - Cerrar oferta
- `DELETE /jobs/{id}` - Eliminar oferta

### ApplicationController
Gestión de solicitudes.

**Rutas:**
- `GET /applications` - Listar solicitudes
- `GET /applications/{id}` - Ver solicitud
- `POST /applications` - Crear solicitud
- `POST /applications/{id}/accept` - Aceptar
- `POST /applications/{id}/reject` - Rechazar
- `POST /applications/{id}/withdraw` - Retirar

### JobSeekerProfileController
Perfiles de demandantes.

**Rutas:**
- `GET /job-seeker/profile` - Ver perfil
- `GET /job-seeker/profile/edit` - Editar perfil
- `PUT /job-seeker/profile` - Actualizar perfil
- `POST /job-seeker/profile/upload-cv` - Cargar CV
- `GET /job-seeker/dashboard` - Dashboard
- `GET /job-seeker/recommended-jobs` - Empleos recomendados
- `GET /job-seeker/matched-jobs` - Empleos coincidentes

### EmployerProfileController
Perfiles de empleadores.

**Rutas:**
- `GET /employer/profile` - Ver perfil
- `GET /employer/profile/edit` - Editar perfil
- `PUT /employer/profile` - Actualizar perfil
- `POST /employer/profile/upload-logo` - Cargar logo
- `GET /employer/dashboard` - Dashboard
- `GET /employer/listings` - Gestionar ofertas
- `GET /employer/applications` - Ver solicitudes
- `GET /employer/analytics` - Ver análisis

### FavoriteController
Gestión de favoritos.

**Rutas:**
- `GET /favorites` - Listar favoritos
- `POST /favorites/{job_id}` - Agregar favorito
- `DELETE /favorites/{id}` - Eliminar favorito
- `POST /favorites/{job_id}/toggle` - Alternar favorito

## 📊 Modelos

### User
```php
// Relaciones
$user->jobSeekerProfile();     // One-to-One
$user->employerProfile();      // One-to-One

// Métodos
$user->isJobSeeker();
$user->isEmployer();
$user->isAdmin();
$user->updateLastLogin();
```

### JobSeekerProfile
```php
// Relaciones
$seeker->user();               // Belongs to
$seeker->workExperiences();    // Has many
$seeker->applications();       // Has many
$seeker->favorites();          // Has many
$seeker->jobMatches();         // Has many

// Métodos
$seeker->isProfileComplete();
$seeker->calculateProfileCompletion();
$seeker->getFullName();
```

### EmployerProfile
```php
// Relaciones
$employer->user();             // Belongs to
$employer->jobListings();      // Has many
$employer->activeJobListings();// Has many (scope)

// Métodos
$employer->getActiveJobCount();
$employer->getTotalApplications();
$employer->getAverageApplicationsPerJob();
$employer->isVerified();
```

### JobListing
```php
// Relaciones
$job->employer();              // Belongs to
$job->applications();          // Has many
$job->favorites();             // Has many
$job->jobMatches();            // Has many

// Scopes
$job->active();                // Solo activas
$job->byWorkMode('remote');
$job->byContractType('full_time');
$job->byLocation('NYC', 'NY');
$job->searchByTitle('developer');
$job->recentlyPosted(7);       // Últimos 7 días

// Métodos
$job->isActive();
$job->getFormattedSalaryRange();
$job->getDaysUntilDeadline();
$job->hasDeadlineExpired();
```

### Application
```php
// Relaciones
$app->jobSeeker();             // Belongs to
$app->jobListing();            // Belongs to

// Scopes
$app->pending();
$app->accepted();
$app->rejected();
$app->withinDays(30);
$app->recentlyApplied(7);

// Métodos
$app->isPending();
$app->isAccepted();
$app->isRejected();
$app->hasBeenViewed();
$app->markAsViewed();
$app->accept('message');
$app->reject('message');
$app->withdraw();
```

## 🎨 Frontend

### Componentes Svelte 5

#### JobCard
Tarjeta de presentación de empleos.
```svelte
<JobCard 
  job={jobData}
  isApplied={false}
  isFavorited={true}
  matchScore={85}
  onApply={handleApply}
  onFavorite={handleFavorite}
/>
```

#### StatsCard
Tarjetas de estadísticas.
```svelte
<StatsCard stats={{
  active_listings: 5,
  total_applications: 45,
  total_listings: 10,
  avg_applications: 4.5
}} />
```

#### Alert
Componentes de alerta.
```svelte
<Alert alert={{
  type: 'success',
  message: 'Operation completed successfully!'
}} />
```

#### Form
Formulario base con validación.
```svelte
<Form title="Edit Profile" onSubmit={handleSubmit}>
  <!-- Contenido del formulario -->
</Form>
```

### Layouts

#### AppLayout
Layout principal de la aplicación.

#### Navigation
Barra de navegación responsive.

#### Sidebar
Menú lateral según tipo de usuario.

#### Footer
Pie de página con links.

## 🔐 Autenticación y Autorización

### Roles y Permisos

#### Job Seeker Permissions
- `view-jobs` - Ver ofertas
- `apply-job` - Postularse a empleos
- `withdraw-application` - Retirar aplicación
- `view-own-applications` - Ver propias aplicaciones
- `view-own-profile` - Ver propio perfil
- `edit-own-profile` - Editar propio perfil
- `upload-cv` - Cargar CV
- `manage-favorite-jobs` - Gestionar favoritos
- `view-matches` - Ver emparejamientos

#### Employer Permissions
- `create-job-listing` - Crear oferta
- `edit-job-listing` - Editar oferta
- `publish-job-listing` - Publicar oferta
- `close-job-listing` - Cerrar oferta
- `delete-job-listing` - Eliminar oferta
- `view-applications` - Ver solicitudes
- `accept-application` - Aceptar solicitud
- `reject-application` - Rechazar solicitud
- `view-analytics` - Ver análisis
- `manage-team` - Gestionar equipo

#### Admin Permissions
- `manage-users` - Gestionar usuarios
- `verify-employers` - Verificar empleadores
- `view-all-users` - Ver todos los usuarios
- `view-all-jobs` - Ver todos los empleos
- `view-all-applications` - Ver todas las solicitudes
- `manage-permissions` - Gestionar permisos
- `manage-roles` - Gestionar roles
- `delete-user` - Eliminar usuario
- `ban-user` - Banear usuario

### Usar en Controlador
```php
// Verificar permisos
$this->authorize('create-job-listing');

// Usar en Policy
public function create(User $user): bool
{
    return $user->hasPermissionTo('create-job-listing');
}

// En Vistas/Frontend
@can('edit-job-listing', $job)
    <a href="{{ route('jobs.edit', $job) }}">Edit</a>
@endcan
```

## 📋 Seeding de Datos

Ejecutar todos los seeders:
```bash
php artisan db:seed
```

Se crearán:
- 1 usuario admin
- 5 demandantes de empleo con perfiles
- 3 empleadores con perfiles
- 9 ofertas de empleo con detalles realistas
- Todos los roles y permisos

**Credenciales de prueba:**
```
Email: admin@yourjob.test
Password: password

Email: seeker1@yourjob.test
Password: password

Email: employer1@yourjob.test
Password: password
```

## 🚀 Deployment

### Variables de Entorno Importantes
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourjob.com

DB_CONNECTION=mysql
DB_HOST=your-host
DB_DATABASE=yourjob_prod
DB_USERNAME=user
DB_PASSWORD=password

MAIL_FROM_ADDRESS=noreply@yourjob.com
MAIL_FROM_NAME="YourJob Platform"
```

### Steps
1. Push a repositorio
2. SSH a servidor
3. `git pull origin main`
4. `composer install --no-dev`
5. `npm install && npm run build`
6. `php artisan migrate --force`
7. `php artisan config:cache`
8. `php artisan route:cache`

## 📝 Licencia

MIT License - Todos los derechos reservados.

## 👥 Contribuciones

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu feature
3. Commit tus cambios
4. Push a la rama
5. Abre un Pull Request

## 📞 Soporte

Para soporte, abre un issue en GitHub o contacta a support@yourjob.com

---

**Desarrollado con ❤️ usando Laravel, Svelte y Bootstrap**
