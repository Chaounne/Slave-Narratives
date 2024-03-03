<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

use App\Controllers\About;
use App\Controllers\Admin;
use App\Controllers\Contact;
use App\Controllers\Lang;
use App\Controllers\Map;
use App\Controllers\Narrative;
use App\Controllers\Narrator;
use App\Controllers\Point;

// map
$routes->get('/', [Map::class, 'index']);

// narrative
$routes->get('/narrative/list', [Narrative::class, 'list']);
$routes->match(['get', 'post'], '/narrative/create', [Narrative::class, 'createOrEdit']);
$routes->match(['get', 'post'], '/narrative/edit/(:segment)', [Narrative::class, 'createOrEdit']);
$routes->get('/narrative/delete/(:segment)/(:segment)', [Narrative::class, 'deleteAllFromNarrative']);
$routes->get('/narrative/(:segment)', [Narrative::class, 'narrative']);

// point
$routes->get('/point/delete/(:segment)', [Point::class, 'deletePoint']);

// narrator
$routes->match(['get', 'post'], '/narrator/list', [Narrator::class, 'list']);
$routes->match(['get', 'post'], '/narrator/create', [Narrator::class, 'createOrEdit']);
$routes->match(['get', 'post'],'/narrator/edit/(:segment)', [Narrator::class, 'createOrEdit']);
$routes->get('/narrator/delete/(:segment)', [Narrator::class, 'delete']);

// lang
$routes->get('/change_lang', [Lang::class, 'change_lang']);

// admin
$routes->get('/admin/login', [Admin::class, 'login']);
$routes->match(['get', 'post'], '/admin/traitLogin', [Admin::class, 'traitLogin']);
$routes->get('/admin/logout', [Admin::class, 'logout']);
$routes->get('/admin', [Admin::class, 'admin']);
$routes->get('/admin/forgotPassword', [Admin::class, 'forgotPassword']);
$routes->match(['get', 'post'], '/admin/traitForgotPassword', [Admin::class, 'traitForgotPassword']);
$routes->get('/admin/token', [Admin::class, 'token']);
$routes->match(['get', 'post'], '/admin/traitTokenPassword', [Admin::class, 'traitTokenPassword']);
$routes->get('/admin/create', [Admin::class, 'create']);
$routes->match(['get', 'post'], '/admin/traitCreate', [Admin::class, 'traitCreate']);
$routes->get('/admin/editMail', [Admin::class, 'editMail']);
$routes->match(['get', 'post'], '/admin/traitEditMail', [Admin::class, 'traitEditMail']);
$routes->get('/admin/editPassword', [Admin::class, 'editPassword']);
$routes->match(['get', 'post'], '/admin/traitEditPassword', [Admin::class, 'traitEditPassword']);
$routes->get('/admin/delete', [Admin::class, 'delete']);
$routes->match(['get', 'post'], '/admin/traitDelete', [Admin::class, 'traitDelete']);
$routes->get('/admin/stats', [Admin::class, 'stats']);

// token
$routes->get('/traitTokenCookie', [Admin::class, 'traitTokenCookie']);

// about
$routes->get('/about', [About::class, 'about']);

// contact
$routes->get('/contact', [Contact::class, 'contact']);
$routes->match(['get', 'post'], '/traitContact', [Contact::class, 'traitContact']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
