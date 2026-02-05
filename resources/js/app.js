import './bootstrap';
import Alpine from 'alpinejs';

// Users
import './users/dependencias-areas';

// Detalles
import './detalle/detalleManager';

// asignacion  
import { formEditar } from  './asignacion/asignacionIndicadores';
window.formEditar = formEditar;

window.Alpine = Alpine;


Alpine.start();
