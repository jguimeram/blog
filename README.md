# TODO List

1. Router
   1. Router class
      1. Methods
      2. Dispatch
      3. Views
   2. Request interface
   3. Response interface
   4. Request and Response factory
2. Auth system
   1. Register
   2. Login
3. CRUD system
4. Notifications system

/blogapp
├── app/
│ ├── Core/ # framework “plumbing” (Router, Database, Bootstrap)
│ │ ├── Interfaces/ # all your interface definitions
│ │ │ ├── ObserverInterface.php
│ │ │ └── …  
│ │ ├── Observer/ # your Observer/Subject implementations
│ │ │ ├── Subject.php
│ │ │ └── NotificationObserver.php
│ │ ├── Factory/ # factories (ControllerFactory, SubscriberFactory…)
│ │ │ └── ControllerFactory.php
│ │ ├── Helpers/ # low-level helpers (URL, View rendering, etc.)
│ │ │ ├── UrlHelper.php
│ │ │ └── ViewHelper.php
│ │ ├── Database.php # Singleton DB connection
│ │ ├── Router.php # Singleton router
│ │ └── bootstrap.php # wiring/autoload setup
│ │
│ ├── Controllers/ # one class per controller
│ │ ├── AuthController.php
│ │ └── PostController.php
│ │
│ ├── Models/ # ActiveRecord-style models & data mappers
│ │ ├── Interfaces/ # e.g. ModelInterface.php
│ │ ├── BaseModel.php
│ │ └── Post.php
│ │
│ ├── Services/ # business-logic classes (e.g. NotificationService)
│ │ └── NotificationService.php
│ │
│ └── Views/ # PHP/HTML templates
│ ├── layouts/ # master layouts
│ │ └── main.php
│ ├── auth/ # login/register
│ │ └── login.php
│ ├── posts/ # post-related pages
│ └── admin/ # admin list/edit templates
│
├── public/ # web root
│ └── index.php # front controller
│
├── resources/ # static assets (css, js, images)
│
├── schema.sql # database schema + seeds
├── composer.json # PSR-4 autoload config
└── README.md
