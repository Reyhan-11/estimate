<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('sneat-template/assets/') }}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>{{ $title ?? ucwords(str_replace('-', ' ', request()->path())) }}</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('logo/favicon.png') }}" />

  <!-- Fonts -->
  {{-- <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> --}}
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('sneat-template/assets/vendor/fonts/boxicons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('sneat-template/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('sneat-template/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('sneat-template/assets/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('sneat-template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  <link rel="stylesheet" href="{{ asset('sneat-template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="{{ asset('sneat-template/assets/vendor/js/helpers.js') }}"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="{{ asset('sneat-template/assets/js/config.js') }}"></script>
  @livewireStyles
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      @include('partials.sidebar')
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                  <i class="bx bx-menu bx-sm"></i>
              </a>
          </div>
      
          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb my-3">
                      <li class="breadcrumb-item">
                          <a href="javascript:void(0);">{{ $title ?? ucwords(str_replace('-', ' ', request()->path())) }}</a>
                      </li>
                  </ol>
              </nav>
      
              <ul class="navbar-nav flex-row align-items-center ms-auto">
      
                  <!-- User -->
                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                          <div class="avatar {{ Auth::check() && Cache::has('user-online' . Auth::user()->id) ? 'avatar-online' : 'avatar-offline' }}">
                              <img src="{{ Auth::check() && Auth::user()->foto != null ? asset('storage/foto_user/' . Auth::user()->foto) : asset('storage/avatar-default/avatar-default.jpg') }}" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                          @if (Auth::check())
                          <li>
                              <a class="dropdown-item" href="#">
                                  <div class="d-flex">
                                      <div class="flex-shrink-0 me-3">
                                          <div class="avatar @if (Cache::has('user-online' . Auth::user()->id)) avatar-online @else avatar-offline @endif">
                                              <img src="{{ Auth::user()->foto != null ? asset('storage/foto_user/' . Auth::user()->foto) : asset('storage/avatar-default/avatar-default.jpg') }}" alt class="w-px-40 h-auto rounded-circle" />
                                          </div>
                                      </div>
                                      <div class="flex-grow-1">
                                          <span class="fw-semibold d-block">{{ ucwords(Auth::user()->name) }}</span>
                                          <small class="text-muted">{{ Auth::user()->divisi ? ucwords(Auth::user()->divisi->name) : '-' }}</small>
                                          <!-- <small class="text-muted">{{ ucwords(Auth::user()->last_activity) }}</small> -->
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li>
                              <div class="dropdown-divider"></div>
                          </li>
                          <li>
                              <a class="dropdown-item {{ request()->is('account-setting/account') ? 'active' : '' }}" href="{{ route('account') }}">
                                  <i class="bx bx-user me-2"></i>
                                  <span class="align-middle">My Profile</span>
                              </a>
                          </li>
                          <li>
                              <a class="dropdown-item {{ request()->is('account-setting/change-password') ? 'active' : '' }}" href="{{ route('change-password') }}">
                                  <i class="bx bx-user me-2"></i>
                                  <span class="align-middle">Change Password</span>
                              </a>
                          </li>
                          <!-- menu logout -->
                          <livewire:otentikasi.logout />
                          @endif
                      </ul>
                  </li>
                  <!--/ User -->
              </ul>
          </div>
        </nav>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            {{ $slot }}
          </div>
          <!-- / Content -->

          <!-- Footer -->
          @include('partials.footer')
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="{{ asset('sneat-template/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('sneat-template/assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('sneat-template/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('sneat-template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

  <script src="{{ asset('sneat-template/assets/vendor/js/menu.js') }}"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('sneat-template/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('sneat-template/assets/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="{{ asset('sneat-template/assets/js/dashboards-analytics.js') }}"></script>
  @livewireScripts
</body>

</html>
