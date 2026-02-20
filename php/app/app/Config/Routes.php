<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Hydrodash;
use App\Controllers\Admin;
use App\Controllers\UserMgt;
use App\Controllers\ApiSync;



/**
 * @var RouteCollection $routes
 */

//
// Dashboard
//

$routes->get('/', [Hydrodash::class, 'discharge']);
$routes->get('watertemp', [Hydrodash::class, 'watertemp']);
$routes->get('precip', [Hydrodash::class, 'precip']);
$routes->get('airtemp', [Hydrodash::class, 'airtemp']);
$routes->get('springs', [Hydrodash::class, 'springs']);
$routes->get('gw', [Hydrodash::class, 'gw']);

$routes->get('discharge/(:num)', [Hydrodash::class, 'discharge_station']);
$routes->get('watertemp/(:num)', [Hydrodash::class, 'watertemp_station']);
$routes->get('precip/(:num)', [Hydrodash::class, 'precip_station']);
$routes->get('airtemp/(:num)', [Hydrodash::class, 'airtemp_station']);
$routes->get('springs/(:num)', [Hydrodash::class, 'springs_station']);
$routes->get('gw/(:num)', [Hydrodash::class, 'gw_station']);

$routes->get('discharge/chart/(:num)', [Hydrodash::class, 'discharge_chart']);
$routes->get('watertemp/chart/(:num)', [Hydrodash::class, 'watertemp_chart']);
$routes->get('precip/chart/(:num)', [Hydrodash::class, 'precip_chart']);
$routes->get('airtemp/chart/(:num)', [Hydrodash::class, 'airtemp_chart']);
$routes->get('springs/chart/(:num)', [Hydrodash::class, 'springs_chart']);
$routes->get('gw/chart/(:num)', [Hydrodash::class, 'gw_chart']);

$routes->get('info', [Hydrodash::class, 'info']);
$routes->get('impressum', [Hydrodash::class, 'imprint']);
$routes->get('datenschutz', [Hydrodash::class, 'privacy']);

//
// Admin
//

$routes->get('admin', [Admin::class, 'admin']);
$routes->get('admin/device/new', [Admin::class, 'new_device']);
$routes->post('admin/device/new', [Admin::class, 'new_device_post']);
$routes->get('admin/device/update/(:num)', [Admin::class, 'update_device']);
$routes->post('admin/device/update/(:num)', [Admin::class, 'update_device_post']);
$routes->get('admin/device/delete/(:num)', [Admin::class, 'delete_device']);
$routes->get('admin/device/job/(:num)', [Admin::class, 'device_job_create']);
$routes->get('admin/device/job/(:num)/del', [Admin::class, 'device_job_delete']);
$routes->get('admin/device/active/(:num)', [Admin::class, 'active_device']); // Activate / deactivate device

$routes->get('admin/analysis/new/(:num)', [Admin::class, 'new_analysis']);
$routes->post('admin/analysis/new/(:num)', [Admin::class, 'new_analysis_post']);
$routes->get('admin/analysis/new/(:num)/(:segment)', [Admin::class, 'new_analysis_set']);
$routes->get('admin/analysis/delete/(:num)', [Admin::class, 'delete_analysis']);
$routes->get('admin/analysis/delete/device/(:num)', [Admin::class, 'delete_analysis_device']);

$routes->get('admin/catchment', [Admin::class, 'catchment']);
$routes->get('admin/catchment/new', [Admin::class, 'new_catchment']);
$routes->post('admin/catchment/new', [Admin::class, 'new_catchment_post']);
$routes->get('admin/catchment/update/(:num)', [Admin::class, 'update_catchment']);
$routes->post('admin/catchment/update/(:num)', [Admin::class, 'update_catchment_post']);
$routes->get('admin/catchment/delete/(:num)', [Admin::class, 'delete_catchment']);

$routes->get('admin/jobs', [Admin::class, 'jobs']);
$routes->get('admin/jobs/(:num)/del', [Admin::class, 'job_delete']);

$routes->get('admin/logs', [Admin::class, 'logs']);

$routes->get('admin/mv/', [Admin::class, 'mv']);
$routes->get('admin/mv/refreshall', [Admin::class, 'refresh_mv_all']);
$routes->get('admin/mv/refresh/(:segment)', [Admin::class, 'refresh_mv']);

//
// CI Shield
//

$routes->get('login', '\App\Controllers\Auth\LoginController::loginView');
$routes->post('login', '\App\Controllers\Auth\LoginController::loginAction');
$routes->get('admin/usermgt', [UserMgt::class, 'user_mgt']);
$routes->post('admin/usermgt/password', [UserMgt::class, 'user_mgt_password_post']);
$routes->post('admin/usermgt/password/(:num)', [UserMgt::class, 'user_mgt_passwordid_post']);
$routes->post('admin/usermgt/email', [UserMgt::class, 'user_mgt_email_post']);
$routes->post('admin/usermgt/email/(:num)', [UserMgt::class, 'user_mgt_emailid_post']);
$routes->post('admin/usermgt/new', [UserMgt::class, 'user_mgt_new_post']);
$routes->get('admin/usermgt/update/(:num)', [UserMgt::class, 'user_mgt_update']);
$routes->get('admin/usermgt/delete/(:num)', [UserMgt::class, 'user_mgt_delete']);
$routes->post('admin/usermgt/update/', [UserMgt::class, 'user_mgt_update_post']);

//
// Sync API
//

$routes->get('api_sync/api_get_analyses', [ApiSync::class, 'api_get_analyses']);
$routes->get('api_sync/api_get_analysis_per_ds', [ApiSync::class, 'api_get_analysis_per_ds']);
$routes->get('api_sync/api_get_categories', [ApiSync::class, 'api_get_categories']);
$routes->get('api_sync/api_get_ds', [ApiSync::class, 'api_get_ds']);
$routes->get('api_sync/api_get_jobs', [ApiSync::class, 'api_get_jobs']);
$routes->get('api_sync/api_get_stammdat', [ApiSync::class, 'api_get_stammdat']);
$routes->get('api_sync/api_get_ts', [ApiSync::class, 'api_get_ts']);
$routes->post('api_sync/api_post_archive_ds_jobs', [ApiSync::class, 'api_post_archive_ds_jobs']);
$routes->post('api_sync/api_post_comment', [ApiSync::class, 'api_post_comment']);
$routes->post('api_sync/api_post_results', [ApiSync::class, 'api_post_results']);
$routes->post('api_sync/api_post_stammdat', [ApiSync::class, 'api_post_stammdat']);
$routes->post('api_sync/api_post_ts', [ApiSync::class, 'api_post_ts']);
$routes->get('api_sync/mv/refreshall', [ApiSync::class, 'refresh_mv_all']);
$routes->get('api_sync/mv/refresh/(:segment)', [ApiSync::class, 'refresh_mv']);

service('auth')->routes($routes);