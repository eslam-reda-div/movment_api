<?php

// lang/dashboard/en/dashboard.php
return [
    'backups' => [
        'group_label' => 'Backups',
        'take_backup' => [
            'label' => 'Take a full database backup',
            'heading' => 'Take a full database backup',
            'description' => "Are you sure you want to take a full database backup now?\nit will empty this tables:\n
            pulse_dashboard_server_monitor_widgets\n
            activity_log",
            'tooltip' => 'Take a full database backup',
            'submit' => 'Yes, take a backup',
            'success' => 'The backup has been taken successfully',
        ],
        'download_backup' => [
            'label' => 'Download the backup files as zip file',
            'heading' => 'Download the backup files as zip file',
            'description' => 'Are you sure you want to download the all backup files as zip file now?',
            'tooltip' => 'Download the backup files as zip file',
            'submit' => 'Yes, download',
            'no_backups' => 'You have no backups',
            'create_error' => 'Unable to create zip file',
        ],
        'delete_backup' => [
            'label' => 'Delete all backup files',
            'heading' => 'Delete all backup files',
            'description' => "Are you sure you want to delete all backup files now?\nthis action can't be undone",
            'tooltip' => 'Delete all backup files',
            'submit' => 'Yes, delete',
            'success' => 'The backup files have been deleted successfully',
            'no_backups' => 'You have no backups',
        ],
    ],
    'resource' => [
        'admin' => [
            'label' => 'Admin',
            'plural_label' => 'Admins',
            'navigation' => [
                'group' => 'Administration',
                'icon' => 'heroicon-o-user-group',
            ],
            'form' => [
                'name' => 'Name',
                'avatar' => 'Avatar',
                'email' => 'Email',
                'phone_number' => 'Phone Number',
                'notes' => 'Notes',
                'password' => 'Password',
                'password_confirmation' => 'Confirm Password',
                'roles_section' => 'Roles',
                'roles' => 'Roles',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'avatar' => 'Avatar',
                'email' => 'Email',
                'phone_number' => 'Phone Number',
                'roles' => 'Roles',
                'created_at' => 'Created At',
            ],
            'messages' => [
                'search' => [
                    'role' => 'Role',
                    'email' => 'Email',
                    'phone' => 'Phone Number',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Admin',
            ],
        ],
        'com_trip' => [
            'label' => 'Trip',
            'plural_label' => 'Trips',
            'status' => [
                'scheduled' => 'Scheduled',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
            ],
            'navigation' => [
                'group' => '',
            ],
            'messages' => [
                'search' => [
                    'path_name' => 'Path Name',
                    'driver_name' => 'Driver Name',
                    'trip_date' => 'Trip Date',
                    'trip_time' => 'Trip Time',
                ],
            ],
            'form' => [
                'start_at_day' => 'Start Date',
                'start_at_time' => 'Start Time',
                'driver' => 'Driver',
                'path' => 'Path',
                'status' => 'Status',
                'notes' => 'Notes',
                'time_picker' => [
                    'confirm' => 'OK',
                    'cancel' => 'Cancel',
                ],
                'status_options' => [
                    'scheduled' => 'Scheduled',
                    'in_progress' => 'In Progress',
                    'completed' => 'Completed',
                ],
            ],
            'table' => [
                'id' => 'ID',
                'start_at_day' => 'Start Date',
                'start_at_time' => 'Start Time',
                'status' => 'Status',
                'domain' => 'Domain',
                'from' => 'From',
                'stops' => 'Stops',
                'to' => 'To',
                'driver_avatar' => 'Driver Avatar',
                'driver_name' => 'Driver Name',
                'driver_phone' => 'Driver Phone',
                'bus_image' => 'Bus Image',
                'bus_number' => 'Bus Number',
                'bus_seats' => 'Bus Seats',
                'created_at' => 'Created At',
            ],
            'actions' => [
                'edit' => 'Edit Trip',
                'delete' => 'Delete Trip',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Trip',
            ],
        ],
        'com_path' => [
            'label' => 'Path',
            'plural_label' => 'Paths',
            'navigation' => [
                'group' => '',
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'domain' => 'Domain',
                    'from' => 'From',
                    'to' => 'To',
                    'stops' => 'Stops',
                ],
            ],
            'form' => [
                'name' => 'Name',
                'domain' => 'Domain',
                'path' => [
                    'label' => 'Path Details',
                    'from' => 'From',
                    'to' => 'To',
                    'stops' => [
                        'label' => 'Stops',
                        'add' => 'Add Stop',
                        'destination' => 'Destination',
                    ],
                ],
                'notes' => 'Notes',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'domain' => 'Domain',
                'from' => 'From',
                'stops' => 'Stops',
                'to' => 'To',
                'created_at' => 'Created At',
            ],
            'actions' => [
                'edit' => 'Edit Path',
                'delete' => 'Delete Path',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Path',
            ],
        ],
        'com_driver' => [
            'label' => 'Driver',
            'plural_label' => 'Drivers',
            'navigation' => [
                'group' => '',
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'phone_number' => 'Phone Number',
                    'home_address' => 'Home Address',
                    'bus' => 'Bus Number',
                ],
            ],
            'form' => [
                'name' => 'Name',
                'home_address' => 'Home Address',
                'avatar' => 'Avatar',
                'phone_number' => 'Phone Number',
                'bus' => 'Bus',
                'notes' => 'Notes',
                'password' => 'Password',
                'password_confirmation' => 'Password Confirmation',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'avatar' => 'Avatar',
                'bus_number' => 'Bus Number',
                'phone_number' => 'Phone Number',
                'home_address' => 'Home Address',
                'created_at' => 'Created At',
            ],
            'actions' => [
                'edit' => 'Edit Driver',
                'delete' => 'Delete Driver',
                'remove_bus' => 'Remove Bus',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Driver',
            ],
        ],
        'com_bus' => [
            'label' => 'Bus',
            'plural_label' => 'Buses',
            'navigation' => [
                'group' => '',
            ],
            'messages' => [
                'search' => [
                    'number' => 'Number',
                    'driver' => 'Driver',
                    'driver_phone' => 'Driver Phone',
                    'seats_count' => 'Seats Count',
                ],
            ],
            'form' => [
                'title' => 'Title',
                'bus_image' => 'Bus Image',
                'number' => 'Bus Number',
                'seats_count' => 'Seats Count',
                'driver' => 'Driver',
                'notes' => 'Notes',
                'is_active' => 'Is Active',
                'limit_reached' => 'You have reached your limit of :limit active buses',
            ],
            'table' => [
                'number' => 'Number',
                'title' => 'Title',
                'bus_image' => 'Bus Image',
                'is_active' => 'Status',
                'seats_count' => 'Seats Count',
                'driver' => 'Driver',
                'created_at' => 'Created At',
                'states' => [
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ],
            ],
            'actions' => [
                'edit' => 'Edit Bus',
                'activate' => 'Activate',
                'activate_limit' => 'Limit Reached',
                'deactivate' => 'Deactivate',
                'remove_driver' => 'Remove Driver',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Bus',
            ],
        ],
        'bus' => [
            'label' => 'Bus',
            'plural_label' => 'Buses',
            'navigation' => [
                'group' => 'Resources',
                'icon' => 'ionicon-bus-outline',
            ],
            'form' => [
                'name' => 'Title',
                'image' => 'Bus Image',
                'number' => 'Number',
                'seats_count' => 'Seats Count',
                'company' => 'Company',
                'driver' => 'Driver',
                'notes' => 'Notes',
                'is_active' => 'Active Status',
                'limit_reached' => 'This company has reached its active bus limit ({0} buses)',
            ],
            'table' => [
                'id' => 'ID',
                'number' => 'Number',
                'name' => 'Title',
                'image' => 'Bus Image',
                'status_lab' => 'Status',
                'status' => [
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ],
                'seats_count' => 'Seats Count',
                'company' => 'Company',
                'driver' => 'Driver',
                'created_at' => 'Created At',
            ],
            'messages' => [
                'search' => [
                    'number' => 'Number',
                    'company' => 'Company',
                    'driver' => 'Driver',
                    'driver_phone' => 'Driver Phone Number',
                    'seats' => 'Seats Count',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'activate' => 'Activate',
                'activate_limit' => 'Activate (Limit)',
                'deactivate' => 'Deactivate',
                'remove_driver' => 'Remove Driver',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Bus',
            ],
            'filters' => [
                'company' => 'Company Name',
            ],
        ],
        'company' => [
            'label' => 'Company',
            'plural_label' => 'Companies',
            'navigation' => [
                'group' => 'Resources',
                'icon' => 'heroicon-o-building-office',
            ],
            'form' => [
                'name' => 'Name',
                'avatar' => 'Avatar',
                'email' => 'Email',
                'phone_number' => 'Phone Number',
                'address' => 'Address',
                'bus_limit' => 'Bus Limit',
                'notes' => 'Notes',
                'password' => 'Password',
                'password_confirmation' => 'Confirm Password',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'avatar' => 'Avatar',
                'email' => 'Email',
                'bus_limit' => 'Bus Limit',
                'drivers_count' => 'Drivers Count',
                'buses_count' => 'Buses Count',
                'trips_count' => 'Trips Count',
                'paths_count' => 'Paths Count',
                'phone_number' => 'Phone Number',
                'address' => 'Address',
                'created_at' => 'Created At',
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'email' => 'Email',
                    'phone_number' => 'Phone Number',
                    'address' => 'Address',
                    'bus_limit' => 'Bus Limit',
                    'bus_count' => 'Bus Count',
                    'driver_count' => 'Driver Count',
                    'trip_count' => 'Trip Count',
                    'path_count' => 'Path Count',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Company',
            ],
        ],
        'destination' => [
            'label' => 'Destination',
            'plural_label' => 'Destinations',
            'navigation' => [
                'group' => 'Resources',
                'icon' => 'fas-location-crosshairs',
            ],
            'form' => [
                'name' => 'Name',
                'domain' => 'Domain',
                'location' => 'Location',
                'notes' => 'Notes',
                'is_active' => 'Active Status',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'domain' => 'Domain',
                'is_active' => 'Status',
                'created_at' => 'Created At',
                'status' => [
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ],
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'domain' => 'Domain',
                    'path_count' => 'Path Count',
                    'paths_from_count' => 'Paths From Count',
                    'paths_to_count' => 'Paths To Count',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Destination',
            ],
        ],
        'domain' => [
            'label' => 'Domain',
            'plural_label' => 'Domains',
            'navigation' => [
                'group' => 'Resources',
                'icon' => 'entypo-location',
            ],
            'form' => [
                'name' => 'Name',
                'notes' => 'Notes',
                'is_active' => 'Active Status',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'destinations_count' => 'Destinations Count',
                'is_active' => 'Status',
                'created_at' => 'Created At',
                'status' => [
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ],
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'destinations' => 'Destinations',
                    'paths' => 'Paths',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Domain',
            ],
        ],
        'driver' => [
            'label' => 'Driver',
            'plural_label' => 'Drivers',
            'navigation' => [
                'group' => 'Resources',
                'icon' => 'healthicons-o-construction-worker',
            ],
            'form' => [
                'name' => 'Name',
                'home_address' => 'Home Address',
                'avatar' => 'Avatar',
                'phone_number' => 'Phone Number',
                'company' => 'Company',
                'bus' => 'Bus',
                'notes' => 'Notes',
                'password' => 'Password',
                'password_confirmation' => 'Confirm Password',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'avatar' => 'Avatar',
                'company' => 'Company',
                'bus_number' => 'Bus Number',
                'phone_number' => 'Phone Number',
                'home_address' => 'Home Address',
                'created_at' => 'Created At',
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'phone_number' => 'Phone Number',
                    'home_address' => 'Home Address',
                    'company' => 'Company',
                    'bus' => 'Bus',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'remove_bus' => 'Remove Bus',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Driver',
            ],
        ],
        'path' => [
            'label' => 'Path',
            'plural_label' => 'Paths',
            'navigation' => [
                'group' => '',
                'icon' => 'bx-trip',
            ],
            'form' => [
                'name' => 'Name',
                'domain' => 'Domain',
                'path' => [
                    'label' => 'Path',
                    'from' => 'From',
                    'to' => 'To',
                    'stops' => [
                        'label' => 'Stops',
                        'add' => 'Add Stop',
                        'destination' => 'Destination',
                    ],
                ],
                'notes' => 'Notes',
            ],
            'table' => [
                'id' => 'ID',
                'name' => 'Name',
                'domain' => 'Domain',
                'from' => 'From',
                'stops' => 'Stops',
                'to' => 'To',
                'created_at' => 'Created At',
            ],
            'messages' => [
                'search' => [
                    'name' => 'Name',
                    'domain' => 'Domain',
                    'from' => 'From',
                    'to' => 'To',
                    'stops' => 'Stops',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Path',
            ],
        ],
        'trip' => [
            'label' => 'Trip',
            'plural_label' => 'Trips',
            'navigation' => [
                'group' => '',
                'icon' => 'entypo-location',
            ],
            'form' => [
                'start_at_day' => 'Start At Day',
                'start_at_time' => 'Start At Time',
                'time_picker' => [
                    'confirm' => 'Confirm',
                    'cancel' => 'Cancel',
                ],
                'driver' => 'Driver',
                'path' => 'Path',
                'status' => 'Status',
                'status_options' => [
                    'scheduled' => 'Scheduled',
                    'in_progress' => 'In Progress',
                    'completed' => 'Completed',
                ],
                'notes' => 'Notes',
            ],
            'table' => [
                'id' => 'ID',
                'start_at_day' => 'Start At Day',
                'start_at_time' => 'Start At Time',
                'status' => 'Status',
                'domain' => 'Domain',
                'from' => 'From',
                'stops' => 'Stops',
                'to' => 'To',
                'driver_avatar' => 'Driver Avatar',
                'driver_name' => 'Driver Name',
                'driver_phone' => 'Driver Phone Number',
                'bus_image' => 'Bus Image',
                'bus_number' => 'Bus Number',
                'bus_seats' => 'Bus Seats Count',
            ],
            'messages' => [
                'search' => [
                    'path_name' => 'Path name',
                    'driver_name' => 'Driver name',
                    'trip_date' => 'Trip Date',
                    'trip_time' => 'Trip Time',
                ],
            ],
            'actions' => [
                'edit' => 'Edit',
                'delete' => 'Delete',
                'bulk_delete' => 'Delete Selected',
                'create' => 'Create Trip',
            ],
        ],
    ],
    'health_check' => [
        'label' => 'Health Check',
        'navigation' => [
            'group' => 'Settings',
            'icon' => 'heroicon-o-cpu-chip',
        ],
        'heading' => 'Health Check Results',
    ],
    'mail_history' => [
        'label' => 'Mail History',
        'navigation' => [
            'group' => 'Settings',
            'icon' => 'fas-history',
        ],
    ],
    'mail_settings' => [
        'label' => 'Mail Settings',
        'navigation' => [
            'group' => 'Settings',
            'icon' => 'heroicon-o-envelope',
        ],
        'form' => [
            'configuration' => [
                'label' => 'Configuration',
                'driver' => 'Driver',
                'driver_options' => [
                    'smtp' => 'SMTP (Recommended)',
                    'mailgun' => 'Mailgun',
                    'ses' => 'Amazon SES',
                    'postmark' => 'Postmark',
                    'log' => 'logging (Development only)',
                ],
                'host' => 'Host',
                'port' => 'Port',
                'encryption' => 'Encryption',
                'encryption_options' => [
                    'ssl' => 'SSL',
                    'tls' => 'TLS',
                    'null' => 'None',
                ],
                'timeout' => 'Timeout',
                'username' => 'Username',
                'password' => 'Password',
            ],
            'sender' => [
                'label' => 'From (Sender)',
                'email' => 'Email',
                'name' => 'Name',
            ],
            'test' => [
                'label' => 'Mail to',
                'email_placeholder' => 'Receiver email..',
                'button' => 'Send Test Mail',
            ],
        ],
        'notifications' => [
            'settings_updated' => 'Mail Settings updated.',
            'test_sent' => 'Mail Sent to: {email}',
        ],
    ],
    'env_editor' => [
        'label' => 'Environment Editor',
        'navigation' => [
            'group' => 'Settings',
            'icon' => 'heroicon-o-cog',
        ],
    ],
    'widget' => [
        'latest_access_logs' => [
            'heading' => 'Latest Access Logs',
        ],
    ],
    'today_trips' => [
        'title' => 'Today Trips',
        'table' => [
            'id' => 'ID',
            'start_at_day' => 'Start At Day',
            'start_at_time' => 'Start At Time',
            'status' => 'Status',
            'domain' => 'Domain',
            'from' => 'From',
            'stops' => 'Stops',
            'to' => 'To',
            'driver_avatar' => 'Driver Avatar',
            'driver_name' => 'Driver Name',
            'driver_phone' => 'Driver Phone Number',
            'bus_image' => 'Bus Image',
            'bus_number' => 'Bus Number',
            'bus_seats' => 'Bus Seats Count',
        ],
        'status' => [
            'scheduled' => 'Scheduled',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
        ],
    ],
    'admin_panel' => [
        'navigation' => [
            'groups' => [
                'administration' => 'Administration',
                'settings' => 'Settings',
            ],
        ],
        'theme' => [
            'colors' => [
                'primary' => 'Blue',
            ],
        ],
        'widgets' => [
            'overview' => 'Overview',
            'server_storage' => 'Server Storage',
            'pulse' => [
                'cache' => 'Cache',
                'exceptions' => 'Exceptions',
                'usage' => 'Usage',
                'queues' => 'Queues',
                'slow_queries' => 'Slow Queries',
            ],
            'latest_access_logs' => 'Latest Access Logs',
        ],
    ],
    'track_map' => [
        'title' => 'Track Map',
        'map' => [
            'default_center' => [
                'lat' => 30.033333,
                'lng' => 31.233334,
            ],
        ],
        'bus' => [
            'status' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
            'info_window' => [
                'bus' => 'Bus',
                'status' => 'Status',
                'trip_info' => 'Trip information',
                'bus_info' => 'Bus information',
                'driver_info' => 'Driver information',
                'status' => [
                    'on_trip' => 'On Trip',
                ],
            ],
            'no_driver' => 'no driver',
        ],
    ],
];
