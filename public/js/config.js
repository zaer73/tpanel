/**
 * INSPINIA - Responsive Admin Theme
 *
 * Inspinia theme use AngularUI Router to manage routing and views
 * Each view are defined as state.
 * Initial there are written state for all view in theme.
 *
 */
function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, IdleProvider, KeepaliveProvider) {

    // Configure Idle settings
    IdleProvider.idle(5); // in seconds
    IdleProvider.timeout(120); // in seconds

    $urlRouterProvider.otherwise("/dashboard/");

    $ocLazyLoadProvider.config({
        // Set to true if you want to see what and when is dynamically loaded
        debug: false
    });

    $stateProvider
        .state('app', {
            url: '',
            abstract: true,
            template: '<div ui-view></div>',
            pageTitle: 'Panel',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                    ]);
                }
            }
        })

        .state('app.dashboards', {
            abstract: true,
            url: "/dashboard/",
            templateUrl: "views/common/content.html",
        })
        .state('app.dashboards.dashboard_1', {
            url: "/1",
            templateUrl: "views/dashboard_1.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {

                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        },
                        {
                            name: 'angles',
                            files: ['js/plugins/chartJs/angles.js', 'js/plugins/chartJs/Chart.min.js']
                        },
                        {
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        }
                    ]);
                }
            }
        })
        .state('app.dashboards.dashboard_2', {
            url: "",
            templateUrl: "views/dashboard_2.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        },
                        {
                            files: ['js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js', 'js/plugins/jvectormap/jquery-jvectormap-2.0.2.css']
                        },
                        {
                            files: ['js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js']
                        },
                        {
                            name: 'ui.checkbox',
                            files: ['js/bootstrap/angular-bootstrap-checkbox.js']
                        },
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.dashboards.dashboard_3', {
            url: "/dashboard_3",
            templateUrl: "views/dashboard_3.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'angles',
                            files: ['js/plugins/chartJs/angles.js', 'js/plugins/chartJs/Chart.min.js']
                        },
                        {
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        {
                            name: 'ui.checkbox',
                            files: ['js/bootstrap/angular-bootstrap-checkbox.js']
                        }
                    ]);
                }
            }
        })
        .state('app.dashboards_top', {
            abstract: true,
            url: "/dashboards_top",
            templateUrl: "views/common/content_top_navigation.html",
        })
        .state('app.dashboards_top.dashboard_4', {
            url: "/dashboard_4",
            templateUrl: "views/dashboard_4.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'angles',
                            files: ['js/plugins/chartJs/angles.js', 'js/plugins/chartJs/Chart.min.js']
                        },
                        {
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        }
                    ]);
                }
            }
        })
        .state('app.dashboards.dashboard_4_1', {
            url: "/dashboard_4_1",
            templateUrl: "views/dashboard_4_1.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'angles',
                            files: ['js/plugins/chartJs/angles.js', 'js/plugins/chartJs/Chart.min.js']
                        },
                        {
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        }
                    ]);
                }
            }
        })
        .state('app.dashboards.dashboard_5', {
            url: "/dashboard_5",
            templateUrl: "views/dashboard_5.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        },
                        {
                            files: ['js/plugins/sparkline/jquery.sparkline.min.js']
                        }
                    ]);
                }
            }
        })

        // 
        // 
        // 
        // 
        .state('app.users', {
            abstract: true,
            templateUrl: "views/common/content.html"
        })
        .state('app.users.home', {
            url: "/users",
            templateUrl: "views/users/index.html",
            permission: 'users_list',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.users.profile', {
            url: "/users/profile", 
            templateUrl: "views/profile.html",
            permission: 'users_profile'
        })
        .state('app.users.user_profile', {
            url: "/users/profile/{id}", 
            templateUrl: "views/profile.html",
            permission: 'users_profile'
        })

        .state('app.users.settings', {
            url: "/users/settings",
            templateUrl: "views/settings.html",
            permission: 'users_settings',
        })

        .state('app.users.report', {
            url: "/users/report",
            templateUrl: "views/report.html",
            // permission: 'users_report',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.users.lawyers', {
            url: "/users/lawyers",
            templateUrl: "views/users/home_lawyer.html",
            permission: 'lawyers',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.users.create', {
            url: "/users/create-lawyer",
            templateUrl: "views/users/create_lawyer.html",
            permission: 'users_create'
        })
        .state('app.users.edit', {
            url: "/users/edit-lawyer/{id}",
            templateUrl: "views/users/edit_lawyer.html",
            permission: 'users_create'
        })

        .state('app.users.credit', {
            url: "/users/credit/{id}",
            templateUrl: "views/credit.html",
        })
        .state('app.users.parent', {
            url: "/users/parent/{id}",
            templateUrl: "views/user/parent.html",
            permission: 'users_create'
        })

        .state('app.admin', {
            abstract: true,
            url: '/admin',
            templateUrl: "views/common/content.html"
        })
        .state('app.admin.users_create', {
            url: "/users/create",
            templateUrl: "views/users/create.html",
            permission: 'users_create'
        })
        .state('app.admin.permissions', {
            abstract: true,
            url: '/permissions',
            templateUrl: "views/common/glue.html",
        })
        .state('app.admin.permissions.groups', {
            abstract: true,
            url: '/groups',
            templateUrl: "views/common/glue.html",
        })
        .state('app.admin.permissions.groups.home', {
            url: "/home",
            templateUrl: "views/permissions/groups.html",
            permission: 'permissions',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.permissions.groups.create', {
            url: "/create", 
            templateUrl: "views/permissions/create_group.html",
            permission: 'permissions',
            resolve: {
                loadPlugin: function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.permissions.groups.edit', {
            url: "/edit/:group_id", 
            templateUrl: "views/permissions/edit_group.html",
            permission: 'permissions',
            resolve: {
                loadPlugin: function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.permissions.user', {
            abstract: true,
            url: '/user',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.permissions.user.edit', {
            url: "/edit/:user_id",
            templateUrl: "views/permissions/user_edit.html",
            permission: 'permissions'
        })

        .state('app.admin.lines', {
            abstract: true,
            url: '/lines',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.lines.show', {
            url: "/show",
            templateUrl: "views/lines/show.html",
            permission: 'lines_view',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.lines.user_show', {
            url: "/show/{id}",
            templateUrl: "views/lines/show.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.lines.edit', {
            url: "/edit/:line_id", 
            templateUrl: "views/lines/edit.html",
            permission: 'lines',
            resolve: {
                loadPlugin: function($ocLazyLoad){
                    return $ocLazyLoad.load([
                        {
                            insertBefore: '#loadBefore',
                            name: 'localytics.directives',
                            files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
                        }
                    ])
                }
            }
        })
        .state('app.admin.lines.create', {
            url: "/create", 
            templateUrl: "views/lines/create.html",
            permission: 'lines',
            resolve: {
                loadPlugin: function($ocLazyLoad){
                    return $ocLazyLoad.load([
                        {
                            insertBefore: '#loadBefore',
                            name: 'localytics.directives',
                            files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
                        }
                    ])
                }
            }
        })
        .state('app.admin.lines.import', {
            url: "/import",
            templateUrl: "views/lines/import.html",
            permission: 'lines',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        }
                    ])
                }
            }
        })
        .state('app.admin.lines.toUser', {
            url: "/to-user/:id", 
            templateUrl: "views/lines/toUser.html",
            permission: 'lines',
            resolve: {
                loadPlugin: function($ocLazyLoad){
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        },
                        {
                            files: ['js/plugins/jasny/jasny-bootstrap.min.js']
                        },
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },

                    ])
                }
            }
        })

        .state('app.admin.news', {
            abstract: true,
            url: '/news',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.news.show', {
            url: "/show",
            templateUrl: "views/news/show.html",
            permission: 'news_create_list',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.news.edit', {
            url: "/edit/:news_id", 
            templateUrl: "views/news/edit.html",
            permission: 'news_create_list',
        })
        .state('app.admin.news.create', {
            url: "/edit", 
            templateUrl: "views/news/create.html",
            permission: 'news_create_list',
        })
        .state('app.admin.line_patterns', {
            abstract: true,
            url: "/line-patterns", 
            templateUrl: "views/common/glue.html",
        })
        .state('app.admin.line_patterns.home', {
            url: "/home", 
            templateUrl: "views/line_patterns/home.html",
            permission: 'line_patterns',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.line_patterns.create', {
            url: "/create", 
            templateUrl: "views/line_patterns/create.html",
        })
        .state('app.admin.line_patterns.edit', {
            url: "/edit/:id", 
            templateUrl: "views/line_patterns/edit.html",
        })

        .state('app.sms', {
            abstract: true,
            templateUrl: "views/common/content.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        },
                        {
                            files: ['js/plugins/jasny/jasny-bootstrap.min.js']
                        }
                    ])
                }
            }
        })
        .state('app.sms.single', {
            url: "/sms/single",
            templateUrl: "views/sms/single.html",
            permission: 'send_single_sms',
        })
        .state('app.sms.singleResend', {
            url: "/sms/single/resend/:id",
            templateUrl: "views/sms/single.html",
            permission: 'send_single_sms',
        })
        .state('app.sms.group', {
            url: "/sms/group",
            templateUrl: "views/sms/group.html",
            permission: 'send_group_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        },
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        }
                    ])
                }
            }
        })
        .state('app.sms.groupResend', {
            url: "/sms/group/resend/:id",
            templateUrl: "views/sms/group.html",
            permission: 'send_group_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        },
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        }
                    ])
                }
            }
        })
        .state('app.sms.city', {
            url: "/sms/city",
            templateUrl: "views/sms/city.html",
            permission: 'send_sms_by_city'
        })
        .state('app.sms.cityResend', {
            url: "/sms/city/resend/:id",
            templateUrl: "views/sms/city.html",
            permission: 'send_sms_by_city'
        })
        .state('app.sms.occupation', {
            url: "/sms/occupation",
            templateUrl: "views/sms/occupation.html",
            permission: 'send_sms_by_occupation'
        })
        .state('app.sms.occupationResend', {
            url: "/sms/occupation/resend/:id",
            templateUrl: "views/sms/occupation.html",
            permission: 'send_sms_by_occupation'
        })
        .state('app.sms.postalCode', {
            url: "/sms/postalCode",
            templateUrl: "views/sms/postalCode.html",
            permission: 'send_sms_by_postal_code'
        })
        .state('app.sms.postalCodeResend', {
            url: "/sms/postalCode/resend/:id",
            templateUrl: "views/sms/postalCode.html",
            permission: 'send_sms_by_postal_code'
        })
        .state('app.sms.gender', {
            url: "/sms/gender",
            abstract: true,
            templateUrl: "views/common/glue.html",
            permission: 'send_sms_by_gender'
        })
        .state('app.sms.gender.add', {
            url: "/create",
            templateUrl: "views/sms/gender.html",
            permission: 'send_sms_by_gender'
        })
        .state('app.sms.gender.list', {
            url: "/list",
            templateUrl: "views/sms/gender_list.html",
            permission: 'send_sms_by_gender',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.sms.genderResend', {
            url: "/sms/gender/resend/:id",
            templateUrl: "views/sms/gender.html",
            permission: 'send_sms_by_gender'
        })
        .state('app.sms.map', {
            url: "/sms/map",
            templateUrl: "views/sms/map.html",
            permission: 'send_sms_by_map',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/sms/map.js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBjV4WKBw71vXdR8KXZTKFLOAa_laPdUd4&callback=initMap']
                        }
                    ]);
                }
            }
        })
        .state('app.sms.brand', {
            url: "/sms/brand",
            templateUrl: "views/sms/brand.html",
            permission: 'send_sms_by_brand',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        }
                    ])
                }
            }
        })
        .state('app.sms.brandResend', {
            url: "/sms/brand/resend/:id",
            templateUrl: "views/sms/brand.html",
            permission: 'send_sms_by_brand',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        }
                    ])
                }
            }
        })
        .state('app.sms.international', {
            url: "/sms/international",
            templateUrl: "views/sms/international.html",
            permission: 'send_international_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        }
                    ])
                }
            }
        })
        .state('app.sms.internationalResend', {
            url: "/sms/international/resend/:id",
            templateUrl: "views/sms/international.html",
            permission: 'send_international_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        }
                    ])
                }
            }
        })
        .state('app.sms.report', {
            url: "/sms/report",
            templateUrl: "views/sms/report.html",
            permission: 'report_for_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.sms.received', {
            url: "/sms/received",
            templateUrl: "views/sms/received.html",
            permission: 'receive_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.sms.schedules', {
            url: '/sms/schedules',
            abstract: true,
            templateUrl: "views/common/glue.html"
        })
        .state('app.sms.schedules.home', {
            url: "/home",
            templateUrl: "views/sms/schedules/home.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.sms.schedules.create', {
            url: "/create",
            templateUrl: "views/sms/schedules/create.html",
            resolve: {
                loadPlugin: function($ocLazyLoad){
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/clockpicker/clockpicker.css', 'js/plugins/clockpicker/clockpicker.js']
                        },
                        {
                            serie: true,
                            files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
                        },
                        {
                            name: 'daterangepicker',
                            files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
                        },
                    ]);
                }
            }
        })
        .state('app.sms.schedules.edit', {
            url: "/edit/:id",
            templateUrl: "views/sms/schedules/edit.html",
            resolve: {
                loadPlugin: function($ocLazyLoad){
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/clockpicker/clockpicker.css', 'js/plugins/clockpicker/clockpicker.js']
                        },
                        {
                            serie: true,
                            files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
                        },
                        {
                            name: 'daterangepicker',
                            files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
                        },
                    ]);
                }
            }
        })
        .state('app.sms.defaultMessages', {
            abstract: true,
            templateUrl: "views/common/glue.html",
            url: '/sms/default-messages'
        })
        .state('app.sms.defaultMessages.home', {
            templateUrl: "views/sms/default_messages/home.html",
            url: '/home', 
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.sms.defaultMessages.create', {
            url: "/create",
            templateUrl: "views/sms/default_messages/create.html",
        })
        .state('app.sms.defaultMessages.edit', {
            url: "/edit/:id",
            templateUrl: "views/sms/default_messages/edit.html",
        })
        .state('app.sms.trash', {
            url: "/sms/trash",
            templateUrl: "views/sms/trash.html",
            permission: 'deleted_sms',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })

        .state('app.admin.priceGroup', {
            abstract: true,
            url: '/price-group',
            templateUrl: "views/common/glue.html"
        })
        // .state('app.admin.priceGroup.home', {
        //     url: "/home",
        //     templateUrl: "views/priceGroup/home.html",
        //     permission: 'price_groups',
        //     resolve: {
        //         loadPlugin: function ($ocLazyLoad) {
        //             return $ocLazyLoad.load([
        //                 {
        //                     serie: true,
        //                     files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
        //                 },
        //                 {
        //                     serie: true,
        //                     name: 'datatables',
        //                     files: ['js/plugins/dataTables/angular-datatables.min.js']
        //                 },
        //                 {
        //                     serie: true,
        //                     name: 'datatables.buttons',
        //                     files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
        //                 },
        //                 {
        //                     files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
        //                 },
        //                 {
        //                     name: 'oitozero.ngSweetAlert',
        //                     files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
        //                 }
        //             ]);
        //         }
        //     }
        // })
        .state('app.admin.priceGroup.create', {
            url: "/create",
            templateUrl: "views/priceGroup/create.html",
            permission: 'price_groups',
        })
        // .state('app.admin.priceGroup.edit', {
        //     url: "/edit/:id",
        //     templateUrl: "views/priceGroup/edit.html",
        //     permission: 'price_groups',
        // })

        .state('app.admin.customizations', {
            abstract: true,
            url: '/customizations',
            templateUrl: "views/common/glue.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        },
                    ]);
                }
            }
        })
        .state('app.admin.customizations.home', {
            url: "/home",
            templateUrl: "views/customizations/home.html",
            permission: 'customization',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'summernote',
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js','js/plugins/summernote/angular-summernote.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.settings', {
            abstract: true,
            url: '/settings',
            templateUrl: "views/common/glue.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        },
                        {
                            name: 'summernote',
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js','js/plugins/summernote/angular-summernote.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.settings.home', {
            url: "/home",
            templateUrl: "views/admin/settings/home.html",
            permission: 'admin_settings',
        })
        .state('app.admin.languages', {
            abstract: true,
            url: '/languages',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.languages.home', {
            url: "/home",
            templateUrl: "views/languages/home.html",
            permission: 'languages',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                    ]);
                }
            }
        })
        .state('app.admin.languages.create', {
            url: "/create",
            templateUrl: "views/languages/create.html",
            permission: 'languages',
        })
        .state('app.admin.languages.edit', {
            url: "/edit/:id",
            templateUrl: "views/languages/edit.html",
            permission: 'languages',
        })

        .state('app.tools.preTexts', {
            abstract: true,
            url: '/pre-texts',
            templateUrl: "views/common/glue.html"
        })
        .state('app.tools.preTexts.home', {
            url: "/home",
            templateUrl: "views/preTexts/home.html",
            permission: 'tools_pretext',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.preTexts.create', {
            url: "/create",
            templateUrl: "views/preTexts/create.html",
            permission: 'tools_pretext',
        })
        .state('app.tools.preTexts.edit', {
            url: "/edit/:id",
            templateUrl: "views/preTexts/edit.html",
            permission: 'tools_pretext',
        })
        .state('app.tools.preTexts.group', {
            abstract: true,
            url: '/group',
            templateUrl: 'views/common/glue.html'
        })
        .state('app.tools.preTexts.group.home', {
            url: "/home",
            templateUrl: "views/preTexts/group/home.html",
            permission: 'tools_pretext',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.preTexts.group.create', {
            url: "/create",
            templateUrl: "views/preTexts/group/create.html",
            permission: 'tools_pretext',
        })
        .state('app.tools.preTexts.group.edit', {
            url: "/edit/:group_id",
            templateUrl: "views/preTexts/group/edit.html",
            permission: 'tools_pretext',
        })
        .state('app.tools.sendFromMobile', {
            abstract: true,
            templateUrl: 'views/common/glue.html',
            url: '/send-from-mobile'
        })
        .state('app.tools.sendFromMobile.home', {
            url: "/home",
            templateUrl: "views/sendFromMobile/home.html",
            permission: 'tools_send_from_mobile',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.sendFromMobile.create', {
            url: "/create",
            templateUrl: "views/sendFromMobile/create.html",
            permission: 'tools_send_from_mobile',
        })

        .state('app.admin.numbersBank', {
            abstract: true,
            url: '/numbers-bank',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.numbersBank.home', {
            url: "/home",
            templateUrl: "views/numbersBank/home.html",
            permission: 'numbers_bank',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.numbersBank.create', {
            url: "/create",
            templateUrl: "views/numbersBank/create.html",
            permission: 'numbers_bank',
        })
        .state('app.admin.numbersBank.edit', {
            url: "/edit/{id}",
            templateUrl: "views/numbersBank/create.html",
            permission: 'numbers_bank',
        })
        .state('app.admin.numbersBank.import', {
            url: "/import",
            templateUrl: "views/numbersBank/import.html",
            permission: 'numbers_bank',
            resolve: {
                loadPlugin: function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        },
                        {
                            serie: true,
                            files: ['js/numbersBank/drawing.js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBjV4WKBw71vXdR8KXZTKFLOAa_laPdUd4&libraries=drawing&callback=initMap']
                        }
                    ]) 
                }
            }
        })

        .state('app.admin.occupations', {
            abstract: true,
            url: '/occupations',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.occupations.home', {
            url: "/home",
            templateUrl: "views/occupations/home.html",
            permission: 'create_occupations',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.occupations.create', {
            url: "/create",
            templateUrl: "views/occupations/create.html",
            permission: 'create_occupations',
        })
        .state('app.admin.occupations.edit', {
            url: "/edit/:id",
            templateUrl: "views/occupations/edit.html",
            permission: 'create_occupations',
        })

        .state('app.admin.postalCode', {
            abstract: true,
            url: '/postal-code',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.postalCode.home', {
            url: "/home",
            templateUrl: "views/postalCode/home.html",
            permission: 'create_postal_codes',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.postalCode.create', {
            url: "/create",
            templateUrl: "views/postalCode/create.html",
            permission: 'create_postal_codes',
        })
        .state('app.admin.postalCode.edit', {
            url: "/edit/:id",
            templateUrl: "views/postalCode/edit.html",
            permission: 'create_postal_codes',
        })

        .state('app.contacts', {
            abstract: true,
            templateUrl: "views/common/content.html"
        })
        .state('app.contacts.home', {
            url: "/contacts/home",
            templateUrl: "views/contacts/home.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.contacts.create', {
            url: "/contacts/create",
            templateUrl: "views/contacts/create.html",
            permission: 'contacts_contacts',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        },
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.contacts.edit', {
            url: "/contacts/edit/:id",
            templateUrl: "views/contacts/edit.html",
            permission: 'contacts_contacts'
        })
        .state('app.contacts.trash', {
            url: "/contacts/trash",
            templateUrl: "views/contacts/trash.html",
            permission: 'contacts_removed',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.contactsGroups', {
            abstract: true,
            templateUrl: "views/common/content.html"
        })
        .state('app.contactsGroups.home', {
            url: "/contacts/groups",
            templateUrl: "views/contacts/groups.html",
            permission: 'contacts_group',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.contactsGroups.create', {
            url: "/contacts/groups/create",
            templateUrl: "views/contacts/groups/create.html",
            permission: 'contacts_group'
        })
        .state('app.contactsGroups.edit', {
            url: "/contacts/groups/edit/:id",
            templateUrl: "views/contacts/groups/edit.html",
            permission: 'contacts_group'
        })

        .state('app.shop', {
            abstract: true,
            templateUrl: "views/common/content.html"
        })
        .state('app.shop.lines', {
            url: "/shop/lines",
            templateUrl: "views/shop/lines.html",
            permission: 'shop_buy_lines',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                    ]);
                }
            }
        })
        .state('app.shop.modules', {
            url: "/shop/modules",
            templateUrl: "views/shop/modules.html",
            permission: 'shop_buy_modules',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                        {
                            name: 'cgNotify',
                            files: ['css/plugins/angular-notify/angular-notify.min.css','js/plugins/angular-notify/angular-notify.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.shop.lineExtension', {
            url: "/shop/line-extension",
            templateUrl: "views/shop/lineExtension.html",
            permission: 'shop_extend_lines',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.shop.specials', {
            url: "/shop/specials",
            templateUrl: "views/shop/specials.html",
            permission: 'shop_special_plans',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.shop.invoice', {
            url: '/shop/invoice',
            templateUrl: 'views/shop/invoice.html',
            permission: 'shop_invoice'
        })
        .state('app.shop.checkout', {
            url: '/shop/checkout',
            templateUrl: 'views/shop/checkout.html',
            permission: 'shop_checkout'
        })
        .state('app.shop.upgrade_credit', {
            url: '/shop/upgrade-credit',
            templateUrl: 'views/shop/upgrade_credit.html',
            permission: 'shop_upgrade_credit'
        })

        .state('app.tools', {
            abstract: true,
            url: '/tools',
            templateUrl: "views/common/content.html",
        })
        .state('app.tools.polls', {
            abstract: true,
            url: '/polls',
            templateUrl: "views/common/glue.html",
        })
        .state('app.tools.polls.home', {
            url: "/home",
            templateUrl: "views/polls/home.html",
            permission: 'tools_poll',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                        {
                            files: ['js/plugins/dotdotdot/jquery.dotdotdot.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.polls.create', {
            url: "/create",
            templateUrl: "views/polls/create.html",
            permission: 'tools_poll',
        })
        .state('app.tools.polls.edit', {
            url: "/edit/:id",
            templateUrl: "views/polls/edit.html",
            permission: 'tools_poll',
        })
        .state('app.tools.polls.show', {
            url: '/show/{id}',
            templateUrl: 'views/polls/show.html',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        }
                    ]);
                }
            }
        })
        .state('app.tools.autoreplies', {
            abstract: true,
            url: '/autoreplies',
            templateUrl: "views/common/glue.html"
        })
        .state('app.tools.autoreplies.home', {
            url: "/home",
            templateUrl: "views/autoreplies/home.html",
            permission: 'tools_auto_answer',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.autoreplies.create', {
            url: "/create",
            templateUrl: "views/autoreplies/create.html",
            permission: 'tools_auto_answer',
        })
        .state('app.tools.autoreplies.edit', {
            url: "/edit/:id",
            templateUrl: "views/autoreplies/edit.html",
            permission: 'tools_auto_answer',
        })

        .state('app.tools.codereaders', {
            abstract: true,
            url: '/codereaders',
            templateUrl: "views/common/glue.html"
        })
        .state('app.tools.codereaders.home', {
            url: "/home",
            templateUrl: "views/codereaders/home.html",
            permission: 'tools_barcode',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.codereaders.create', {
            url: "/create",
            templateUrl: "views/codereaders/create.html",
            permission: 'tools_barcode',
        })
        .state('app.tools.codereaders.edit', {
            url: "/edit/:id",
            templateUrl: "views/codereaders/edit.html",
            permission: 'tools_barcode',
        })

        .state('app.tools.blacklist', {
            abstract: true,
            url: '/blacklist',
            templateUrl: "views/common/glue.html"
        })
        .state('app.tools.blacklist.home', {
            url: "/home",
            templateUrl: "views/blacklist/home.html",
            permission: 'tools_blacklist',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.blacklist.create', {
            url: "/create",
            templateUrl: "views/blacklist/create.html",
            permission: 'tools_blacklist',
        })
        .state('app.tools.blacklist.edit', {
            url: "/edit/:id",
            templateUrl: "views/blacklist/edit.html",
            permission: 'tools_blacklist',
        })

        .state('app.tools.transferToEmail', {
            abstract: true,
            url: '/transfer-to-email',
            templateUrl: "views/common/glue.html"
        })
        .state('app.tools.transferToEmail.home', {
            url: "/home",
            templateUrl: "views/transferToEmail/home.html",
            permission: 'tools_send_to_email',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.transferToEmail.create', {
            url: "/create",
            templateUrl: "views/transferToEmail/create.html",
            permission: 'tools_send_to_email',
        })
        .state('app.tools.transferToEmail.edit', {
            url: "/edit/:id",
            templateUrl: "views/transferToEmail/edit.html",
            permission: 'tools_send_to_email',
        })

        .state('app.tools.receiveSettings', {
            abstract: true,
            url: '/receive-settings',
            templateUrl: "views/common/glue.html"
        })
        .state('app.tools.receiveSettings.home', {
            url: "/home",
            templateUrl: "views/receiveSettings/home.html",
            permission: 'tools_recieve_setting',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tools.receiveSettings.edit', {
            url: "/edit/:id",
            templateUrl: "views/receiveSettings/edit.html",
            permission: 'tools_recieve_setting',
        })

        .state('app.admin.modules', {
            abstract: true,
            url: '/modules',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.modules.home', {
            url: "/home",
            templateUrl: "views/modules/home.html",
            permission: 'managing_modules',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.modules.create', {
            url: "/create",
            templateUrl: "views/modules/create.html",
            permission: 'managing_modules',
        })
        .state('app.admin.modules.edit', {
            url: "/edit/:id",
            templateUrl: "views/modules/edit.html",
            permission: 'managing_modules',
        })

        .state('app.admin.specials', {
            abstract: true,
            url: '/specials',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.specials.home', {
            url: "/home",
            templateUrl: "views/specials/home.html",
            permission: 'managing_specials',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.specials.create', {
            url: "/create",
            templateUrl: "views/specials/create.html",
            permission: 'managing_specials',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.specials.edit', {
            url: "/edit/:id",
            templateUrl: "views/specials/edit.html",
            permission: 'managing_specials',
        })

        .state('app.admin.plans', {
            abstract: true,
            url: '/plans',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.plans.home', {
            url: "/home",
            templateUrl: "views/plans/home.html",
            permission: 'managing_plans',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.plans.create', {
            url: "/create",
            templateUrl: "views/plans/create.html",
            permission: 'managing_plans',
            resolve: {
                loadPlugin: function($ocLazyLoad){
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.plans.edit', {
            url: "/edit/:id",
            templateUrl: "views/plans/edit.html",
            permission: 'managing_plans',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        }
                    ])
                }
            }
        })
        .state('app.admin.backup', {
            url: '/backup',
            templateUrl: "views/backup/backup.html"
        })

        .state('app.admin.filterings', {
            abstract: true,
            url: '/filterings',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.filterings.home', {
            url: "/home",
            templateUrl: "views/filterings/home.html",
            permission: 'managing_filterings',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.filterings.create', {
            url: "/create",
            templateUrl: "views/filterings/create.html",
            permission: 'managing_filterings',
        })
        .state('app.admin.filterings.edit', {
            url: "/edit/:id",
            templateUrl: "views/filterings/edit.html",
            permission: 'managing_filterings',
        })

        .state('app.admin.faqs', {
            abstract: true,
            url: '/faqs',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.faqs.home', {
            url: "/home",
            templateUrl: "views/faqs/home.html",
            permission: 'create_faqs',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.faqs.create', {
            url: "/create",
            templateUrl: "views/faqs/create.html",
            permission: 'create_faqs',
        })
        .state('app.admin.faqs.edit', {
            url: "/edit/:id",
            templateUrl: "views/faqs/edit.html",
            permission: 'create_faqs',
        })

        .state('app.admin.charges', {
            abstract: true,
            url: '/charges',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.charges.home', {
            url: "/home",
            templateUrl: "views/charges/home.html",
            permission: 'create_charges',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.charges.create', {
            url: "/create",
            templateUrl: "views/charges/create.html",
            permission: 'create_charges',
        })
        .state('app.admin.charges.edit', {
            url: "/edit/:id",
            templateUrl: "views/charges/edit.html",
            permission: 'create_charges',
        })

        .state('app.admin.fluent_credit', {
            abstract: true,
            url: '/fluent-credit',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.fluent_credit.home', {
            url: "/home",
            templateUrl: "views/fluent_credit/home.html",
            permission: 'fluent_credit',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.fluent_credit.create', {
            url: "/create",
            templateUrl: "views/fluent_credit/create.html",
            permission: 'fluent_credit',
        })
        .state('app.admin.fluent_credit.edit', {
            url: "/edit/:id",
            templateUrl: "views/fluent_credit/edit.html",
            permission: 'fluent_credit',
        })
        .state('app.admin.fluent_credit.groups', {
            abstract: true, 
            url: "/groups",
            templateUrl: "views/common/glue.html",
        })
        .state('app.admin.fluent_credit.groups.home', {
            url: "/home",
            templateUrl: "views/fluent_credit/groups/home.html",
            permission: 'fluent_credit',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.admin.fluent_credit.groups.create', {
            url: "/create",
            templateUrl: "views/fluent_credit/groups/create.html",
            permission: 'fluent_credit',
        })
        .state('app.admin.fluent_credit.groups.edit', {
            url: "/edit/:id",
            templateUrl: "views/fluent_credit/groups/edit.html",
            permission: 'fluent_credit',
        })

        .state('app.admin.marketingCodes', {
            abstract: true,
            url: '/marketing-codes',
            templateUrl: "views/common/glue.html"
        })
        .state('app.admin.marketingCodes.home', {
            url: "/home",
            templateUrl: "views/marketingCodes/home.html",
            permission: 'marketing_codes',
            // resolve: {
            //     loadPlugin: function ($ocLazyLoad) {
            //         return $ocLazyLoad.load([
            //             {
            //                 serie: true,
            //                 files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
            //             },
            //             {
            //                 serie: true,
            //                 name: 'datatables',
            //                 files: ['js/plugins/dataTables/angular-datatables.min.js']
            //             },
            //             {
            //                 serie: true,
            //                 name: 'datatables.buttons',
            //                 files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
            //             }
            //         ]);
            //     }
            // }
        })
        // .state('app.marketingCodes.create', {
        //     url: "/marketing-codes/create",
        //     templateUrl: "views/marketingCodes/create.html",
        //     permission: 'marketing_codes',
        // })

        .state('app.support', {
            abstract: true,
            templateUrl: "views/common/content.html"
        })
        .state('app.support.tickets', {
            url: "/support/tickets",
            templateUrl: "views/support/tickets.html",
            permission: 'support_tickets',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.support.ticket_answer', {
            url: "/support/tickets/answer/{id}",
            templateUrl: "views/support/answer.html",
            permission: 'support_tickets',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.support.show_ticket', {
            url: "/support/tickets/{id}",
            templateUrl: "views/support/show.html",
            permission: 'support_tickets',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })/*
        .state('app.support.online', {
            abstract: true,
            url: "/support/online",
            templateUrl: "views/common/glue.html",
        })*/
        .state('app.support.online.list', {
            url: "/list",
            templateUrl: "views/support/online/list.html",
            permission: 'support_online',
        })
        .state('app.support.online.chat', {
            url: "/chat/:id",
            templateUrl: "views/support/online.html",
            permission: 'support_online',
        })
        .state('app.support.aboutUs', {
            url: "/support/about-us",
            templateUrl: "views/support/aboutUs.html",
            permission: 'support_aboutUs',
        })
        .state('app.support.contactUs', {
            url: "/support/contact-us",
            templateUrl: "views/support/contactUs.html",
            permission: 'support_contactUs'
        })
        .state('app.support.ourServices', {
            url: "/support/our-services",
            templateUrl: "views/support/ourServices.html",
            permission: 'support_ourServices',
        })
        .state('app.support.faq', {
            url: "/support/faq",
            templateUrl: "views/support/faq.html",
            permission: 'support_faq'
        })
        .state('app.support.marketing', {
            url: "/support/marketing",
            templateUrl: "views/support/marketing.html",
            permission: 'support_marketing'
        })

        .state('app.financial', {
            abstract: true,
            templateUrl: "views/common/content.html"
        })
        .state('app.financial.onlineCharge', {
            url: "/financial/online-charge",
            templateUrl: "views/financial/onlineCharge.html",
            permission: 'financial_charge'
        })
        .state('app.financial.submitBill', {
            url: "/financial/submit-bill",
            templateUrl: "views/financial/submitBill.html",
            permission: 'financial_receipt'
        })
        .state('app.financial.submittedBills', {
            url: "/financial/submitted-bills",
            templateUrl: "views/financial/submittedBills.html",
            permission: 'financial_receipt',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.financial.transactions', {
            url: "/financial/transactions",
            templateUrl: "views/financial/transactions.html",
            permission: 'financial_transactions',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                    ])
                }
            }
        })
        .state('app.financial.report', {
            url: "/financial/report",
            templateUrl: "views/financial/report.html",
            permission: 'financial_credit_report',
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        },
                    ])
                }
            }
        })

        // 
        // 
        // 
        // 
        // 
        // 


        .state('app.layouts', {
            url: "/layouts",
            templateUrl: "views/layouts.html",
        })
        .state('app.charts', {
            abstract: true,
            url: "/charts",
            templateUrl: "views/common/content.html",
        })
        .state('app.charts.flot_chart', {
            url: "/flot_chart",
            templateUrl: "views/graph_flot.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        }
                    ]);
                }
            }
        })
        .state('app.charts.rickshaw_chart', {
            url: "/rickshaw_chart",
            templateUrl: "views/graph_rickshaw.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            reconfig: true,
                            serie: true,
                            files: ['js/plugins/rickshaw/vendor/d3.v3.js','js/plugins/rickshaw/rickshaw.min.js']
                        },
                        {
                            reconfig: true,
                            name: 'angular-rickshaw',
                            files: ['js/plugins/rickshaw/angular-rickshaw.js']
                        }
                    ]);
                }
            }
        })
        .state('app.charts.peity_chart', {
            url: "/peity_chart",
            templateUrl: "views/graph_peity.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        }
                    ]);
                }
            }
        })
        .state('app.charts.sparkline_chart', {
            url: "/sparkline_chart",
            templateUrl: "views/graph_sparkline.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/sparkline/jquery.sparkline.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.charts.chartjs_chart', {
            url: "/chartjs_chart",
            templateUrl: "views/chartjs.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/chartJs/Chart.min.js']
                        },
                        {
                            name: 'angles',
                            files: ['js/plugins/chartJs/angles.js']
                        }
                    ]);
                }
            }
        })
        .state('app.charts.chartist_chart', {
            url: "/chartist_chart",
            templateUrl: "views/chartist.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-chartist',
                            files: ['js/plugins/chartist/chartist.min.js', 'css/plugins/chartist/chartist.min.css', 'js/plugins/chartist/angular-chartist.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.charts.c3charts', {
            url: "/c3charts",
            templateUrl: "views/c3charts.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['css/plugins/c3/c3.min.css', 'js/plugins/d3/d3.min.js', 'js/plugins/c3/c3.min.js']
                        },
                        {
                            serie: true,
                            name: 'gridshore.c3js.chart',
                            files: ['js/plugins/c3/c3-angular.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.mailbox', {
            abstract: true,
            url: "/mailbox",
            templateUrl: "views/common/content.html",
        })
        .state('app.mailbox.inbox', {
            url: "/inbox",
            templateUrl: "views/mailbox.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.mailbox.email_view', {
            url: "/email_view",
            templateUrl: "views/mail_detail.html",
        })
        .state('app.mailbox.email_compose', {
            url: "/email_compose",
            templateUrl: "views/mail_compose.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js']
                        },
                        {
                            name: 'summernote',
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js','js/plugins/summernote/angular-summernote.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.mailbox.email_template', {
            url: "/email_template",
            templateUrl: "views/email_template.html",
        })
        .state('app.widgets', {
            url: "/widgets",
            templateUrl: "views/widgets.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/plugins/flot/jquery.flot.js', 'js/plugins/flot/jquery.flot.time.js', 'js/plugins/flot/jquery.flot.tooltip.min.js', 'js/plugins/flot/jquery.flot.spline.js', 'js/plugins/flot/jquery.flot.resize.js', 'js/plugins/flot/jquery.flot.pie.js', 'js/plugins/flot/curvedLines.js', 'js/plugins/flot/angular-flot.js', ]
                        },
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        },
                        {
                            files: ['js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js', 'js/plugins/jvectormap/jquery-jvectormap-2.0.2.css']
                        },
                        {
                            files: ['js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js']
                        },
                        {
                            name: 'ui.checkbox',
                            files: ['js/bootstrap/angular-bootstrap-checkbox.js']
                        }
                    ]);
                }
            }
        })
        .state('app.metrics', {
            url: "/metrics",
            templateUrl: "views/metrics.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/sparkline/jquery.sparkline.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.forms', {
            abstract: true,
            url: "/forms",
            templateUrl: "views/common/content.html",
        })
        .state('app.forms.basic_form', {
            url: "/basic_form",
            templateUrl: "views/form_basic.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.forms.advanced_plugins', {
            url: "/advanced_plugins",
            templateUrl: "views/form_advanced.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.knob',
                            files: ['js/plugins/jsKnob/jquery.knob.js','js/plugins/jsKnob/angular-knob.js']
                        },
                        {
                            files: ['css/plugins/ionRangeSlider/ion.rangeSlider.css','css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css','js/plugins/ionRangeSlider/ion.rangeSlider.min.js']
                        },
                        {
                            insertBefore: '#loadBefore',
                            name: 'localytics.directives',
                            files: ['css/plugins/chosen/chosen.css','js/plugins/chosen/chosen.jquery.js','js/plugins/chosen/chosen.js']
                        },
                        {
                            name: 'nouislider',
                            files: ['css/plugins/nouslider/jquery.nouislider.css','js/plugins/nouslider/jquery.nouislider.min.js','js/plugins/nouslider/angular-nouislider.js']
                        },
                        {
                            name: 'datePicker',
                            files: ['css/plugins/datapicker/angular-datapicker.css','js/plugins/datapicker/angular-datepicker.js']
                        },
                        {
                            files: ['js/plugins/jasny/jasny-bootstrap.min.js']
                        },
                        {
                            files: ['css/plugins/clockpicker/clockpicker.css', 'js/plugins/clockpicker/clockpicker.js']
                        },
                        {
                            name: 'ui.switchery',
                            files: ['css/plugins/switchery/switchery.css','js/plugins/switchery/switchery.js','js/plugins/switchery/ng-switchery.js']
                        },
                        {
                            name: 'colorpicker.module',
                            files: ['css/plugins/colorpicker/colorpicker.css','js/plugins/colorpicker/bootstrap-colorpicker-module.js']
                        },
                        {
                            name: 'ngImgCrop',
                            files: ['js/plugins/ngImgCrop/ng-img-crop.js','css/plugins/ngImgCrop/ng-img-crop.css']
                        },
                        {
                            serie: true,
                            files: ['js/plugins/moment/moment.min.js', 'js/plugins/daterangepicker/daterangepicker.js', 'css/plugins/daterangepicker/daterangepicker-bs3.css']
                        },
                        {
                            name: 'daterangepicker',
                            files: ['js/plugins/daterangepicker/angular-daterangepicker.js']
                        },
                        {
                            files: ['css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css']
                        },
                        {
                            name: 'ui.select',
                            files: ['js/plugins/ui-select/select.min.js', 'css/plugins/ui-select/select.min.css']
                        },
                        {
                            files: ['css/plugins/touchspin/jquery.bootstrap-touchspin.min.css', 'js/plugins/touchspin/jquery.bootstrap-touchspin.min.js']
                        }

                    ]);
                }
            }
        })
        .state('app.forms.wizard', {
            url: "/wizard",
            templateUrl: "views/form_wizard.html",
            controller: wizardCtrl,
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/steps/jquery.steps.css']
                        }
                    ]);
                }
            }
        })
        .state('app.forms.wizard.step_one', {
            url: '/step_one',
            templateUrl: 'views/wizard/step_one.html',
        })
        .state('app.forms.wizard.step_two', {
            url: '/step_two',
            templateUrl: 'views/wizard/step_two.html',
        })
        .state('app.forms.wizard.step_three', {
            url: '/step_three',
            templateUrl: 'views/wizard/step_three.html',
        })
        .state('app.forms.file_upload', {
            url: "/file_upload",
            templateUrl: "views/form_file_upload.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/dropzone/basic.css','css/plugins/dropzone/dropzone.css','js/plugins/dropzone/dropzone.js']
                        }
                    ]);
                }
            }
        })
        .state('app.forms.text_editor', {
            url: "/text_editor",
            templateUrl: "views/form_editors.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'summernote',
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js','js/plugins/summernote/angular-summernote.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.forms.markdown', {
            url: "/markdown",
            templateUrl: "views/markdown.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/bootstrap-markdown/bootstrap-markdown.js','js/plugins/bootstrap-markdown/markdown.js','css/plugins/bootstrap-markdown/bootstrap-markdown.min.css']
                        }
                    ]);
                }
            }
        })
        .state('app.app', {
            abstract: true,
            url: "/app",
            templateUrl: "views/common/content.html",
        })
        .state('app.app.contacts', {
            url: "/contacts",
            templateUrl: "views/contacts.html",
        })
        .state('app.app.contacts_2', {
            url: "/contacts_2",
            templateUrl: "views/contacts_2.html",
        })
        .state('app.app.profile', {
            url: "/profile",
            templateUrl: "views/profile.html",
        })
        .state('app.app.profile_2', {
            url: "/profile_2",
            templateUrl: "views/profile_2.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/sparkline/jquery.sparkline.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.app.projects', {
            url: "/projects",
            templateUrl: "views/projects.html",
        })
        .state('app.app.project_detail', {
            url: "/project_detail",
            templateUrl: "views/project_detail.html",
        })
        .state('app.app.file_manager', {
            url: "/file_manager",
            templateUrl: "views/file_manager.html",
        })
        .state('app.app.calendar', {
            url: "/calendar",
            templateUrl: "views/calendar.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            insertBefore: '#loadBefore',
                            files: ['css/plugins/fullcalendar/fullcalendar.css','js/plugins/fullcalendar/fullcalendar.min.js','js/plugins/fullcalendar/gcal.js']
                        },
                        {
                            name: 'ui.calendar',
                            files: ['js/plugins/fullcalendar/calendar.js']
                        }
                    ]);
                }
            }
        })
        .state('app.app.faq', {
            url: "/faq",
            templateUrl: "views/faq.html",
        })
        .state('app.app.timeline', {
            url: "/timeline",
            templateUrl: "views/timeline.html",
        })
        .state('app.app.pin_board', {
            url: "/pin_board",
            templateUrl: "views/pin_board.html",
        })
        .state('app.app.invoice', {
            url: "/invoice",
            templateUrl: "views/invoice.html",
        })
        .state('app.app.blog', {
            url: "/blog",
            templateUrl: "views/blog.html",
        })
        .state('app.app.article', {
            url: "/article",
            templateUrl: "views/article.html",
        })
        .state('app.app.issue_tracker', {
            url: "/issue_tracker",
            templateUrl: "views/issue_tracker.html",
        })
        .state('app.app.clients', {
            url: "/clients",
            templateUrl: "views/clients.html",
        })
        .state('app.app.teams_board', {
            url: "/teams_board",
            templateUrl: "views/teams_board.html",
        })
        .state('app.app.social_feed', {
            url: "/social_feed",
            templateUrl: "views/social_feed.html",
        })
        .state('app.app.vote_list', {
            url: "/vote_list",
            templateUrl: "views/vote_list.html",
        })
        .state('app.pages', {
            abstract: true,
            url: "/pages",
            templateUrl: "views/common/content.html"
        })
        .state('app.pages.search_results', {
            url: "/search_results",
            templateUrl: "views/search_results.html",
        })
        .state('app.pages.empy_page', {
            url: "/empy_page",
            templateUrl: "views/empty_page.html",
        })
        .state('app.login', {
            url: "/login",
            templateUrl: "views/login.html",
        })
        .state('app.login_two_columns', {
            url: "/login_two_columns",
            templateUrl: "views/login_two_columns.html",
        })
        .state('app.register', {
            url: "/register",
            templateUrl: "views/register.html",
        })
        .state('app.lockscreen', {
            url: "/lockscreen",
            templateUrl: "views/lockscreen.html",
        })
        .state('app.forgot_password', {
            url: "/forgot_password",
            templateUrl: "views/forgot_password.html",
        })
        .state('app.errorOne', {
            url: "/errorOne",
            templateUrl: "views/errorOne.html",
        })
        .state('app.errorTwo', {
            url: "/errorTwo",
            templateUrl: "views/errorTwo.html",
        })
        .state('app.ui', {
            abstract: true,
            url: "/ui",
            templateUrl: "views/common/content.html",
        })
        .state('app.ui.typography', {
            url: "/typography",
            templateUrl: "views/typography.html",
        })
        .state('app.ui.icons', {
            url: "/icons",
            templateUrl: "views/icons.html",
        })
        .state('app.ui.buttons', {
            url: "/buttons",
            templateUrl: "views/buttons.html",
        })
        .state('app.ui.tabs_panels', {
            url: "/tabs_panels",
            templateUrl: "views/tabs_panels.html",
        })
        .state('app.ui.tabs', {
            url: "/tabs",
            templateUrl: "views/tabs.html",
        })
        .state('app.ui.notifications_tooltips', {
            url: "/notifications_tooltips",
            templateUrl: "views/notifications.html",
        })
        .state('app.ui.badges_labels', {
            url: "/badges_labels",
            templateUrl: "views/badges_labels.html",
        })
        .state('app.ui.video', {
            url: "/video",
            templateUrl: "views/video.html",
        })
        .state('app.ui.draggable', {
            url: "/draggable",
            templateUrl: "views/draggable.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.sortable',
                            files: ['js/plugins/ui-sortable/sortable.js']
                        }
                    ]);
                }
            }
        })
        .state('app.grid_options', {
            url: "/grid_options",
            templateUrl: "views/grid_options.html",
        })
        .state('app.miscellaneous', {
            abstract: true,
            url: "/miscellaneous",
            templateUrl: "views/common/content.html",
        })
        .state('app.miscellaneous.google_maps', {
            url: "/google_maps",
            templateUrl: "views/google_maps.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.event',
                            files: ['js/plugins/uievents/event.js']
                        },
                        {
                            name: 'ui.map',
                            files: ['js/plugins/uimaps/ui-map.js']
                        },
                    ]);
                }
            }
        })
        .state('app.miscellaneous.code_editor', {
            url: "/code_editor",
            templateUrl: "views/code_editor.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['css/plugins/codemirror/codemirror.css','css/plugins/codemirror/ambiance.css','js/plugins/codemirror/codemirror.js','js/plugins/codemirror/mode/javascript/javascript.js']
                        },
                        {
                            name: 'ui.codemirror',
                            files: ['js/plugins/ui-codemirror/ui-codemirror.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.modal_window', {
            url: "/modal_window",
            templateUrl: "views/modal_window.html",
        })
        .state('app.miscellaneous.chat_view', {
            url: "/chat_view",
            templateUrl: "views/chat_view.html",
        })
        .state('app.miscellaneous.nestable_list', {
            url: "/nestable_list",
            templateUrl: "views/nestable_list.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.tree',
                            files: ['css/plugins/uiTree/angular-ui-tree.min.css','js/plugins/uiTree/angular-ui-tree.min.js']
                        },
                    ]);
                }
            }
        })
        .state('app.miscellaneous.notify', {
            url: "/notify",
            templateUrl: "views/notify.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'cgNotify',
                            files: ['css/plugins/angular-notify/angular-notify.min.css','js/plugins/angular-notify/angular-notify.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.timeline_2', {
            url: "/timeline_2",
            templateUrl: "views/timeline_2.html",
        })
        .state('app.miscellaneous.forum_view', {
            url: "/forum_view",
            templateUrl: "views/forum_view.html",
        })
        .state('app.miscellaneous.forum_post_view', {
            url: "/forum_post_view",
            templateUrl: "views/forum_post_view.html",
        })
        .state('app.miscellaneous.diff', {
            url: "/diff",
            templateUrl: "views/diff.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/diff_match_patch/javascript/diff_match_patch.js']
                        },
                        {
                            name: 'diff-match-patch',
                            files: ['js/plugins/angular-diff-match-patch/angular-diff-match-patch.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.sweet_alert', {
            url: "/sweet_alert",
            templateUrl: "views/sweet_alert.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/sweetalert/sweetalert.min.js', 'css/plugins/sweetalert/sweetalert.css']
                        },
                        {
                            name: 'oitozero.ngSweetAlert',
                            files: ['js/plugins/sweetalert/angular-sweetalert.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.idle_timer', {
            url: "/idle_timer",
            templateUrl: "views/idle_timer.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'cgNotify',
                            files: ['css/plugins/angular-notify/angular-notify.min.css','js/plugins/angular-notify/angular-notify.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.live_favicon', {
            url: "/live_favicon",
            templateUrl: "views/live_favicon.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/tinycon/tinycon.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.spinners', {
            url: "/spinners",
            templateUrl: "views/spinners.html",
        })
        .state('app.miscellaneous.validation', {
            url: "/validation",
            templateUrl: "views/validation.html",
        })
        .state('app.miscellaneous.agile_board', {
            url: "/agile_board",
            templateUrl: "views/agile_board.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ui.sortable',
                            files: ['js/plugins/ui-sortable/sortable.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.masonry', {
            url: "/masonry",
            templateUrl: "views/masonry.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/masonry/masonry.pkgd.min.js']
                        },
                        {
                            name: 'wu.masonry',
                            files: ['js/plugins/masonry/angular-masonry.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.toastr', {
            url: "/toastr",
            templateUrl: "views/toastr.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.i18support', {
            url: "/i18support",
            templateUrl: "views/i18support.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            insertBefore: '#loadBefore',
                            name: 'toaster',
                            files: ['js/plugins/toastr/toastr.min.js', 'css/plugins/toastr/toastr.min.css']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.truncate', {
            url: "/truncate",
            templateUrl: "views/truncate.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/dotdotdot/jquery.dotdotdot.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.clipboard', {
            url: "/clipboard",
            templateUrl: "views/clipboard.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/ngclipboard/clipboard.min.js']
                        },
                        {
                            name: 'ngclipboard',
                            files: ['js/plugins/ngclipboard/ngclipboard.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.loading_buttons', {
            url: "/loading_buttons",
            templateUrl: "views/loading_buttons.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-ladda',
                            files: ['js/plugins/ladda/spin.min.js', 'js/plugins/ladda/ladda.min.js', 'css/plugins/ladda/ladda-themeless.min.css','js/plugins/ladda/angular-ladda.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.tour', {
            url: "/tour",
            templateUrl: "views/tour.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            insertBefore: '#loadBefore',
                            files: ['js/plugins/bootstrap-tour/bootstrap-tour.min.js', 'css/plugins/bootstrap-tour/bootstrap-tour.min.css']
                        },
                        {
                            name: 'bm.bsTour',
                            files: ['js/plugins/angular-bootstrap-tour/angular-bootstrap-tour.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.miscellaneous.tree_view', {
            url: "/tree_view",
            templateUrl: "views/tree_view.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/jsTree/style.min.css','js/plugins/jsTree/jstree.min.js']
                        },
                        {
                            name: 'ngJsTree',
                            files: ['js/plugins/jsTree/ngJsTree.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tables', {
            abstract: true,
            url: "/tables",
            templateUrl: "views/common/content.html"
        })
        .state('app.tables.static_table', {
            url: "/static_table",
            templateUrl: "views/table_basic.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'angular-peity',
                            files: ['js/plugins/peity/jquery.peity.min.js', 'js/plugins/peity/angular-peity.js']
                        },
                        {
                            files: ['css/plugins/iCheck/custom.css','js/plugins/iCheck/icheck.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tables.data_tables', {
            url: "/data_tables",
            templateUrl: "views/table_data_tables.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['js/plugins/dataTables/datatables.min.js','css/plugins/dataTables/datatables.min.css']
                        },
                        {
                            serie: true,
                            name: 'datatables',
                            files: ['js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            name: 'datatables.buttons',
                            files: ['js/plugins/dataTables/angular-datatables.buttons.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tables.foo_table', {
            url: "/foo_table",
            templateUrl: "views/foo_table.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/footable/footable.all.min.js', 'css/plugins/footable/footable.core.css']
                        },
                        {
                            name: 'ui.footable',
                            files: ['js/plugins/footable/angular-footable.js']
                        }
                    ]);
                }
            }
        })
        .state('app.tables.nggrid', {
            url: "/nggrid",
            templateUrl: "views/nggrid.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            name: 'ngGrid',
                            files: ['js/plugins/nggrid/ng-grid-2.0.3.min.js']
                        },
                        {
                            insertBefore: '#loadBefore',
                            files: ['js/plugins/nggrid/ng-grid.css']
                        }
                    ]);
                }
            }
        })
        .state('app.commerce', {
            abstract: true,
            url: "/commerce",
            templateUrl: "views/common/content.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/footable/footable.all.min.js', 'css/plugins/footable/footable.core.css']
                        },
                        {
                            name: 'ui.footable',
                            files: ['js/plugins/footable/angular-footable.js']
                        }
                    ]);
                }
            }
        })
        .state('app.commerce.products_grid', {
            url: "/products_grid",
            templateUrl: "views/ecommerce_products_grid.html",
        })
        .state('app.commerce.product_list', {
            url: "/product_list",
            templateUrl: "views/ecommerce_product_list.html",
        })
        .state('app.commerce.orders', {
            url: "/orders",
            templateUrl: "views/ecommerce_orders.html",
        })
        .state('app.commerce.product', {
            url: "/product",
            templateUrl: "views/ecommerce_product.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js']
                        },
                        {
                            name: 'summernote',
                            files: ['css/plugins/summernote/summernote.css','css/plugins/summernote/summernote-bs3.css','js/plugins/summernote/summernote.min.js','js/plugins/summernote/angular-summernote.min.js']
                        }
                    ]);
                }
            }

        })
        .state('app.commerce.product_details', {
            url: "/product_details",
            templateUrl: "views/ecommerce_product_details.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/slick/slick.css','css/plugins/slick/slick-theme.css','js/plugins/slick/slick.min.js']
                        },
                        {
                            name: 'slick',
                            files: ['js/plugins/slick/angular-slick.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.commerce.payments', {
            url: "/payments",
            templateUrl: "views/ecommerce_payments.html",
        })
        .state('app.commerce.cart', {
            url: "/cart",
            templateUrl: "views/ecommerce_cart.html",
        })
        .state('app.gallery', {
            abstract: true,
            url: "/gallery",
            templateUrl: "views/common/content.html"
        })
        .state('app.gallery.basic_gallery', {
            url: "/basic_gallery",
            templateUrl: "views/basic_gallery.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['js/plugins/blueimp/jquery.blueimp-gallery.min.js','css/plugins/blueimp/css/blueimp-gallery.min.css']
                        }
                    ]);
                }
            }
        })
        .state('app.gallery.bootstrap_carousel', {
            url: "/bootstrap_carousel",
            templateUrl: "views/carousel.html",
        })
        .state('app.gallery.slick_gallery', {
            url: "/slick_gallery",
            templateUrl: "views/slick.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            files: ['css/plugins/slick/slick.css','css/plugins/slick/slick-theme.css','js/plugins/slick/slick.min.js']
                        },
                        {
                            name: 'slick',
                            files: ['js/plugins/slick/angular-slick.min.js']
                        }
                    ]);
                }
            }
        })
        .state('app.css_animations', {
            url: "/css_animations",
            templateUrl: "views/css_animation.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            reconfig: true,
                            serie: true,
                            files: ['js/plugins/rickshaw/vendor/d3.v3.js','js/plugins/rickshaw/rickshaw.min.js']
                        },
                        {
                            reconfig: true,
                            name: 'angular-rickshaw',
                            files: ['js/plugins/rickshaw/angular-rickshaw.js']
                        }
                    ]);
                }
            }

        })
        .state('app.landing', {
            url: "/landing",
            templateUrl: "views/landing.html",
        })
        .state('app.outlook', {
            url: "/outlook",
            templateUrl: "views/outlook.html",
        })
        .state('app.off_canvas', {
            url: "/off_canvas",
            templateUrl: "views/off_canvas.html",
        });

}
angular
    .module('inspinia')
    .config(config)
    .run(['$rootScope', '$state', function($rootScope, $state) {
        $rootScope.$state = $state;
    }]);
