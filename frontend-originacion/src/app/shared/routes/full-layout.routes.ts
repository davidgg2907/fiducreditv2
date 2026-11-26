import { Routes } from '@angular/router';
import { pendingModuleGuard } from '../../guards/pending-module.guard';
import { originacionPermissionGuard } from '../../guards/originacion-permission.guard';

export const Full_ROUTES: Routes = [
  { path: 'home', loadComponent: () => import('../../modules/home/home.component').then(m => m.HomeComponent) },
  { path: 'perfil', loadComponent: () => import('../../modules/profile/profile.component').then(m => m.ProfileComponent) },
  {
    path: 'clientes',
    canActivate: [originacionPermissionGuard],
    data: { module: 'clientes', action: 'ver' },
    loadComponent: () => import('../../modules/clientes/list/clientes-list.component').then(m => m.ClientesListComponent)
  },
  {
    path: 'clientes/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'clientes', action: 'crear' },
    loadComponent: () => import('../../modules/clientes/form/clientes-form.component').then(m => m.ClientesFormComponent)
  },
  {
    path: 'clientes/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'clientes', action: 'editar' },
    loadComponent: () => import('../../modules/clientes/form/clientes-form.component').then(m => m.ClientesFormComponent)
  },
  {
    path: 'clientes/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'clientes', action: 'detalle' },
    loadComponent: () => import('../../modules/clientes/detail/clientes-detail.component').then(m => m.ClientesDetailComponent)
  },
  {
    path: 'domicilios',
    canActivate: [originacionPermissionGuard],
    data: { module: 'domicilios', action: 'ver' },
    loadComponent: () => import('../../modules/domicilios/list/domicilios-list.component').then(m => m.DomiciliosListComponent)
  },
  {
    path: 'domicilios/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'domicilios', action: 'crear' },
    loadComponent: () => import('../../modules/domicilios/form/domicilios-form.component').then(m => m.DomiciliosFormComponent)
  },
  {
    path: 'domicilios/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'domicilios', action: 'editar' },
    loadComponent: () => import('../../modules/domicilios/form/domicilios-form.component').then(m => m.DomiciliosFormComponent)
  },
  {
    path: 'domicilios/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'domicilios', action: 'detalle' },
    loadComponent: () => import('../../modules/domicilios/detail/domicilios-detail.component').then(m => m.DomiciliosDetailComponent)
  },
  {
    path: 'cuentas_bancarias',
    canActivate: [originacionPermissionGuard],
    data: { module: 'cuentas_bancarias', action: 'ver' },
    loadComponent: () => import('../../modules/cuentas_bancarias/list/cuentas_bancarias-list.component').then(m => m.CuentasBancariasListComponent)
  },
  {
    path: 'cuentas_bancarias/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'cuentas_bancarias', action: 'crear' },
    loadComponent: () => import('../../modules/cuentas_bancarias/form/cuentas_bancarias-form.component').then(m => m.CuentasBancariasFormComponent)
  },
  {
    path: 'cuentas_bancarias/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'cuentas_bancarias', action: 'editar' },
    loadComponent: () => import('../../modules/cuentas_bancarias/form/cuentas_bancarias-form.component').then(m => m.CuentasBancariasFormComponent)
  },
  {
    path: 'cuentas_bancarias/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'cuentas_bancarias', action: 'detalle' },
    loadComponent: () => import('../../modules/cuentas_bancarias/detail/cuentas_bancarias-detail.component').then(m => m.CuentasBancariasDetailComponent)
  },
  {
    path: 'documentos',
    canActivate: [originacionPermissionGuard],
    data: { module: 'documentos', action: 'ver' },
    loadComponent: () => import('../../modules/documentos/list/documentos-list.component').then(m => m.DocumentosListComponent)
  },
  {
    path: 'documentos/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'documentos', action: 'detalle' },
    loadComponent: () => import('../../modules/documentos/detail/documentos-detail.component').then(m => m.DocumentosDetailComponent)
  },
  {
    path: 'expedientes',
    canActivate: [originacionPermissionGuard],
    data: { module: 'expedientes', action: 'ver' },
    loadComponent: () => import('../../modules/expedientes/list/expedientes-list.component').then(m => m.ExpedientesListComponent)
  },
  {
    path: 'expedientes/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'expedientes', action: 'detalle' },
    loadComponent: () => import('../../modules/expedientes/detail/expedientes-detail.component').then(m => m.ExpedientesDetailComponent)
  },
  {
    path: 'solicitudes',
    canActivate: [originacionPermissionGuard],
    data: { module: 'solicitudes', action: 'ver' },
    loadComponent: () => import('../../modules/solicitudes/list/solicitudes-list.component').then(m => m.SolicitudesListComponent)
  },
  {
    path: 'solicitudes/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'solicitudes', action: 'crear' },
    loadComponent: () => import('../../modules/solicitudes/capture/solicitudes-capture.component').then(m => m.SolicitudesCaptureComponent)
  },
  {
    path: 'solicitudes/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'solicitudes', action: 'editar' },
    loadComponent: () => import('../../modules/solicitudes/capture/solicitudes-capture.component').then(m => m.SolicitudesCaptureComponent)
  },
  {
    path: 'solicitudes/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'solicitudes', action: 'detalle' },
    loadComponent: () => import('../../modules/solicitudes/detail/solicitudes-detail.component').then(m => m.SolicitudesDetailComponent)
  },
  {
    path: 'conceptos_financieros',
    canActivate: [originacionPermissionGuard],
    data: { module: 'conceptos_financieros', action: 'ver' },
    loadComponent: () => import('../../modules/conceptos_financieros/list/conceptos_financieros-list.component').then(m => m.ConceptosFinancierosListComponent)
  },
  {
    path: 'conceptos_financieros/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'conceptos_financieros', action: 'crear' },
    loadComponent: () => import('../../modules/conceptos_financieros/form/conceptos_financieros-form.component').then(m => m.ConceptosFinancierosFormComponent)
  },
  {
    path: 'conceptos_financieros/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'conceptos_financieros', action: 'editar' },
    loadComponent: () => import('../../modules/conceptos_financieros/form/conceptos_financieros-form.component').then(m => m.ConceptosFinancierosFormComponent)
  },
  {
    path: 'conceptos_financieros/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'conceptos_financieros', action: 'detalle' },
    loadComponent: () => import('../../modules/conceptos_financieros/detail/conceptos_financieros-detail.component').then(m => m.ConceptosFinancierosDetailComponent)
  },
  {
    path: 'consentimientos',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consentimientos', action: 'ver' },
    loadComponent: () => import('../../modules/consentimientos/list/consentimientos-list.component').then(m => m.ConsentimientosListComponent)
  },
  {
    path: 'consentimientos/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consentimientos', action: 'crear' },
    loadComponent: () => import('../../modules/consentimientos/form/consentimientos-form.component').then(m => m.ConsentimientosFormComponent)
  },
  {
    path: 'consentimientos/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consentimientos', action: 'detalle' },
    loadComponent: () => import('../../modules/consentimientos/detail/consentimientos-detail.component').then(m => m.ConsentimientosDetailComponent)
  },
  {
    path: 'obligados_solidarios',
    canActivate: [originacionPermissionGuard],
    data: { module: 'obligados_solidarios', action: 'ver' },
    loadComponent: () => import('../../modules/obligados_solidarios/list/obligados_solidarios-list.component').then(m => m.ObligadosSolidariosListComponent)
  },
  {
    path: 'obligados_solidarios/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'obligados_solidarios', action: 'crear' },
    loadComponent: () => import('../../modules/obligados_solidarios/form/obligados_solidarios-form.component').then(m => m.ObligadosSolidariosFormComponent)
  },
  {
    path: 'obligados_solidarios/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'obligados_solidarios', action: 'editar' },
    loadComponent: () => import('../../modules/obligados_solidarios/form/obligados_solidarios-form.component').then(m => m.ObligadosSolidariosFormComponent)
  },
  {
    path: 'obligados_solidarios/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'obligados_solidarios', action: 'detalle' },
    loadComponent: () => import('../../modules/obligados_solidarios/detail/obligados_solidarios-detail.component').then(m => m.ObligadosSolidariosDetailComponent)
  },
  {
    path: 'mesa_control',
    canActivate: [originacionPermissionGuard],
    data: { module: 'mesa_control', action: 'ver' },
    loadComponent: () => import('../../modules/mesa_control/list/mesa_control-list.component').then(m => m.MesaControlListComponent)
  },
  {
    path: 'mesa_control/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'mesa_control', action: 'detalle' },
    loadComponent: () => import('../../modules/mesa_control/detail/mesa_control-detail.component').then(m => m.MesaControlDetailComponent)
  },
  {
    path: 'tareas_originacion',
    canActivate: [originacionPermissionGuard],
    data: { module: 'tareas_originacion', action: 'ver' },
    loadComponent: () => import('../../modules/tareas_originacion/list/tareas_originacion-list.component').then(m => m.TareasOriginacionListComponent)
  },
  {
    path: 'tareas_originacion/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'tareas_originacion', action: 'detalle' },
    loadComponent: () => import('../../modules/tareas_originacion/detail/tareas_originacion-detail.component').then(m => m.TareasOriginacionDetailComponent)
  },
  {
    path: 'analisis_crediticio',
    canActivate: [originacionPermissionGuard],
    data: { module: 'analisis_crediticio', action: 'ver' },
    loadComponent: () => import('../../modules/analisis_crediticio/list/analisis_crediticio-list.component').then(m => m.AnalisisCrediticioListComponent)
  },
  {
    path: 'analisis_crediticio/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'analisis_crediticio', action: 'crear' },
    loadComponent: () => import('../../modules/analisis_crediticio/form/analisis_crediticio-form.component').then(m => m.AnalisisCrediticioFormComponent)
  },
  {
    path: 'analisis_crediticio/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'analisis_crediticio', action: 'editar' },
    loadComponent: () => import('../../modules/analisis_crediticio/form/analisis_crediticio-form.component').then(m => m.AnalisisCrediticioFormComponent)
  },
  {
    path: 'analisis_crediticio/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'analisis_crediticio', action: 'detalle' },
    loadComponent: () => import('../../modules/analisis_crediticio/detail/analisis_crediticio-detail.component').then(m => m.AnalisisCrediticioDetailComponent)
  },
  {
    path: 'consultas_buro',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consultas_buro', action: 'ver' },
    loadComponent: () => import('../../modules/consultas_buro/list/consultas_buro-list.component').then(m => m.ConsultasBuroListComponent)
  },
  {
    path: 'consultas_buro/nuevo',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consultas_buro', action: 'crear' },
    loadComponent: () => import('../../modules/consultas_buro/form/consultas_buro-form.component').then(m => m.ConsultasBuroFormComponent)
  },
  {
    path: 'consultas_buro/:id/editar',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consultas_buro', action: 'editar' },
    loadComponent: () => import('../../modules/consultas_buro/form/consultas_buro-form.component').then(m => m.ConsultasBuroFormComponent)
  },
  {
    path: 'consultas_buro/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'consultas_buro', action: 'detalle' },
    loadComponent: () => import('../../modules/consultas_buro/detail/consultas_buro-detail.component').then(m => m.ConsultasBuroDetailComponent)
  },
  {
    path: 'dictamenes',
    canActivate: [originacionPermissionGuard],
    data: { module: 'dictamenes', action: 'ver' },
    loadComponent: () => import('../../modules/dictamenes/list/dictamenes-list.component').then(m => m.DictamenesListComponent)
  },
  {
    path: 'dictamenes/:id',
    canActivate: [originacionPermissionGuard],
    data: { module: 'dictamenes', action: 'detalle' },
    loadComponent: () => import('../../modules/dictamenes/detail/dictamenes-detail.component').then(m => m.DictamenesDetailComponent)
  },
  { path: '**', canActivate: [pendingModuleGuard], loadComponent: () => import('../../modules/pending-module/pending-module.component').then(m => m.PendingModuleComponent) },
];
