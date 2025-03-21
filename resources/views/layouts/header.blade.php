<!DOCTYPE html>
<html lang="en" dir="">
   <head>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width,initial-scale=1" />
      <meta http-equiv="X-UA-Compatible" content="ie=edge" />
      <title>{{ $title ?? 'Ibiblio' }}</title>
      <link
         href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900"
         rel="stylesheet"
         />
      <link
         href="../../dist-assets/css/themes/lite-purple.min.css"
         rel="stylesheet"
         />
      <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css"rel="stylesheet"/>

      <link href="../../dist-assets/css/main.css"rel="stylesheet"/>
         <!-- Include Select2 JS -->
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
   </head>
   <body class="text-start">
      <div class="app-admin-wrap layout-sidebar-large">
         <div class="main-header">
            <div class="logo">
               <img src="../../dist-assets/images/logo.png" alt="" />
            </div>
            <div class="menu-toggle">
               <div></div>
               <div></div>
               <div></div>
            </div>
            <div class="d-flex align-items-center">
               <!-- Mega menu -->
               <div class="dropdown mega-menu d-none d-md-block">
                  <a
                     href="#"
                     class="btn text-muted dropdown-toggle me-3"
                     id="dropdownMegaMenuButton"
                     data-bs-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false"
                     >Mega Menu</a
                     >
                  <div
                     class="dropdown-menu text-start"
                     aria-labelledby="dropdownMenuButton"
                     >
                     <div class="row m-0">
                        <div class="col-md-4 p-4 bg-img">
                           <h2 class="title">
                              Mega Menu <br />
                              Sidebar
                           </h2>
                           <p>
                              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                              Asperiores natus laboriosam fugit, consequatur.
                           </p>
                           <p class="mb-4">
                              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                              Exercitationem odio amet eos dolore suscipit placeat.
                           </p>
                           <button class="btn btn-lg btn-rounded btn-outline-warning">
                           Learn More
                           </button>
                        </div>
                        <div class="col-md-4 p-4">
                           <p
                              class="text-primary text--cap border-bottom-primary d-inline-block"
                              >
                              Features
                           </p>
                           <div class="menu-icon-grid w-auto p-0">
                              <a href="#"><i class="i-Shop-4"></i> Home</a>
                              <a href="#"><i class="i-Library"></i> UI Kits</a>
                              <a href="#"><i class="i-Drop"></i> Apps</a>
                              <a href="#"
                                 ><i class="i-File-Clipboard-File--Text"></i> Forms</a
                                 >
                              <a href="#"><i class="i-Checked-User"></i> Sessions</a>
                              <a href="#"><i class="i-Ambulance"></i> Support</a>
                           </div>
                        </div>
                        <div class="col-md-4 p-4">
                           <p
                              class="text-primary text--cap border-bottom-primary d-inline-block"
                              >
                              Components
                           </p>
                           <ul class="links">
                              <li><a href="accordion.html">Accordion</a></li>
                              <li><a href="alerts.html">Alerts</a></li>
                              <li><a href="buttons.html">Buttons</a></li>
                              <li><a href="badges.html">Badges</a></li>
                              <li><a href="carousel.html">Carousels</a></li>
                              <li><a href="lists.html">Lists</a></li>
                              <li><a href="popover.html">Popover</a></li>
                              <li><a href="tables.html">Tables</a></li>
                              <li><a href="datatables.html">Datatables</a></li>
                              <li><a href="modals.html">Modals</a></li>
                              <li><a href="nouislider.html">Sliders</a></li>
                              <li><a href="tabs.html">Tabs</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- / Mega menu -->
               <div class="search-bar">
                  <input type="text" placeholder="Search" />
                  <i class="search-icon text-muted i-Magnifi-Glass1"></i>
               </div>
            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right">
               <!-- Full screen toggle -->
               <i
                  class="i-Full-Screen header-icon d-none d-sm-inline-block"
                  data-fullscreen
                  ></i>
               <!-- Grid menu Dropdown -->
               <div class="dropdown">
                  <i
                     class="i-Safe-Box text-muted header-icon"
                     role="button"
                     id="dropdownMenuButton"
                     data-bs-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false"
                     ></i>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <div class="menu-icon-grid">
                        <a href="#"><i class="i-Shop-4"></i> Home</a>
                        <a href="#"><i class="i-Library"></i> UI Kits</a>
                        <a href="#"><i class="i-Drop"></i> Apps</a>
                        <a href="#"
                           ><i class="i-File-Clipboard-File--Text"></i> Forms</a
                           >
                        <a href="#"><i class="i-Checked-User"></i> Sessions</a>
                        <a href="#"><i class="i-Ambulance"></i> Support</a>
                     </div>
                  </div>
               </div>
               <!-- Notificaiton -->
               <div class="dropdown">
                  <div
                     class="badge-top-container"
                     role="button"
                     id="dropdownNotification"
                     data-bs-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false"
                     >
                     <span class="badge bg-primary">3</span>
                     <i class="i-Bell text-muted header-icon"></i>
                  </div>
                  <!-- Notification dropdown -->
                  <div
                     class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none"
                     aria-labelledby="dropdownNotification"
                     data-perfect-scrollbar
                     data-suppress-scroll-x="true"
                     >
                     <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                           <i class="i-Speach-Bubble-6 text-primary me-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                           <p class="m-0 d-flex align-items-center">
                              <span>New message</span>
                              <span class="badge rounded-pill text-bg-primary ms-1 me-1"
                                 >new</span
                                 >
                              <span class="flex-grow-1"></span>
                              <span class="text-small text-muted ms-auto"
                                 >10 sec ago</span
                                 >
                           </p>
                           <p class="text-small text-muted m-0">
                              James: Hey! are you busy?
                           </p>
                        </div>
                     </div>
                     <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                           <i class="i-Receipt-3 text-success me-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                           <p class="m-0 d-flex align-items-center">
                              <span>New order received</span>
                              <span class="badge rounded-pill text-bg-success ms-1 me-1"
                                 >new</span
                                 >
                              <span class="flex-grow-1"></span>
                              <span class="text-small text-muted ms-auto"
                                 >2 hours ago</span
                                 >
                           </p>
                           <p class="text-small text-muted m-0">
                              1 Headphone, 3 iPhone x
                           </p>
                        </div>
                     </div>
                     <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                           <i class="i-Empty-Box text-danger me-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                           <p class="m-0 d-flex align-items-center">
                              <span>Product out of stock</span>
                              <span class="badge rounded-pill text-bg-danger ms-1 me-1"
                                 >3</span
                                 >
                              <span class="flex-grow-1"></span>
                              <span class="text-small text-muted ms-auto"
                                 >10 hours ago</span
                                 >
                           </p>
                           <p class="text-small text-muted m-0">
                              Headphone E67, R98, XL90, Q77
                           </p>
                        </div>
                     </div>
                     <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                           <i class="i-Data-Power text-success me-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                           <p class="m-0 d-flex align-items-center">
                              <span>Server Up!</span>
                              <span class="badge rounded-pill text-bg-success ms-1 me-1"
                                 >3</span
                                 >
                              <span class="flex-grow-1"></span>
                              <span class="text-small text-muted ms-auto"
                                 >14 hours ago</span
                                 >
                           </p>
                           <p class="text-small text-muted m-0">
                              Server rebooted successfully
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Notificaiton End -->
               <!-- User avatar dropdown -->
               <div class="dropdown">
                  <div class="user col align-self-end">
                     <img
                        src="../../dist-assets/images/faces/1.jpg"
                        id="userDropdown"
                        alt=""
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        />
                     <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="userDropdown"
                        >
                        <div class="dropdown-header">
                           <i class="i-Lock-User me-1"></i> Timothy Carlson
                        </div>
                        <a class="dropdown-item">Account settings</a>
                        <a class="dropdown-item">Billing history</a>
                        <a class="dropdown-item" href="signin.html">Sign out</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>