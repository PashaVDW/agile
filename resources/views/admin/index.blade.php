<!DOCTYPE html>
<html
  class="h-full"
  data-theme="true"
  data-theme-mode="light"
  dir="ltr"
  lang="en"
>
  @include("admin.partials.head")
  <body
    class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:var(--tw-coal-300)] [--tw-content-bg:var(--tw-light)] [--tw-content-bg-dark:var(--tw-coal-500)] [--tw-content-scrollbar-color:#e8e8e8] [--tw-header-height:60px] [--tw-sidebar-width:270px] bg-[--tw-page-bg] lg:overflow-hidden"
  >
    <!-- Theme Mode -->
    <script>
      const defaultThemeMode = 'light'; // light|dark|system
      let themeMode;

      if (document.documentElement) {
        if (localStorage.getItem('theme')) {
          themeMode = localStorage.getItem('theme');
        } else if (document.documentElement.hasAttribute('data-theme-mode')) {
          themeMode = document.documentElement.getAttribute('data-theme-mode');
        } else {
          themeMode = defaultThemeMode;
        }

        if (themeMode === 'system') {
          themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
        }

        document.documentElement.classList.add(themeMode);
      }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <!-- Base -->
    <div class="flex grow">
      <!-- Header -->
      <header
        class="flex lg:hidden items-center fixed z-10 top-0 start-0 end-0 shrink-0 bg-[--tw-page-bg] h-[--tw-header-height]"
        id="header"
      >
        <!-- Container -->
        <div
          class="container-fixed flex items-center justify-between flex-wrap gap-3"
        >
          <a href="html/demo10.html"></a>
          <button
            class="btn btn-icon btn-light btn-clear btn-sm -me-2"
            data-drawer-toggle="#sidebar"
          >
            <i class="ki-filled ki-menu"></i>
          </button>
        </div>
        <!-- End of Container -->
      </header>
      <!-- End of Header -->
      <!-- Wrapper -->
      <div
        class="flex flex-col lg:flex-row grow pt-[--tw-header-height] lg:pt-0"
      >
        <!-- Sidebar -->
        <div
          class="flex-col fixed top-0 bottom-0 z-20 hidden lg:flex items-stretch shrink-0 w-[--tw-sidebar-width] dark"
          data-drawer="true"
          data-drawer-class="drawer drawer-start flex top-0 bottom-0"
          data-drawer-enable="true|lg:false"
          id="sidebar"
        >
          <!-- Sidebar Header -->
          <!-- End of Sidebar Header -->
          <!-- Sidebar menu -->
          <div
            class="flex items-stretch grow shrink-0 justify-center my-5"
            id="sidebar_menu"
          >
            <div
              class="scrollable-y-auto grow [--tw-scrollbar-thumb-color:var(--tw-gray-300)]"
              data-scrollable="true"
              data-scrollable-dependencies="#sidebar_header, #sidebar_footer"
              data-scrollable-height="auto"
              data-scrollable-offset="0px"
              data-scrollable-wrappers="#sidebar_menu"
            >
              <!-- Primary Menu -->
              <div class="mb-5">
                <h3
                  class="text-sm text-gray-500 uppercase ps-5 inline-block mb-3"
                >
                  Pages
                </h3>
                <div
                  class="menu flex flex-col w-full gap-1.5 px-3.5"
                  data-menu="true"
                  data-menu-accordion-expand-all="false"
                  id="sidebar_primary_menu"
                >
                  <!-- Overview -->
                  <div class="menu-item">
                    <a
                      class="menu-link gap-2.5 py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100 !menu-item-here:bg-transparent"
                      href="html/demo10.html"
                    >
                      <span
                        class="menu-icon items-start text-lg text-gray-600 menu-item-active:text-gray-900 menu-item-here:text-gray-900"
                      >
                        <i class="ki-filled ki-home-3"></i>
                      </span>
                      <span
                        class="menu-title text-sm text-gray-800 font-medium menu-item-here:text-gray-900 menu-item-active:text-gray-900 menu-link-hover:text-gray-900"
                      >
                        Overview
                      </span>
                    </a>
                  </div>
                    <!-- Public events -->
                    <div class="menu-item">
                        <a
                            class="menu-link gap-2.5 py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100 !menu-item-here:bg-transparent"
                            href="{{route('admin.events.index')}}"
                        >
                      <span
                          class="menu-icon items-start text-lg text-gray-600 menu-item-active:text-gray-900 menu-item-here:text-gray-900"
                      >
                        <i class="ki-filled ki-home-3"></i>
                      </span>
                            <span
                                class="menu-title text-sm text-gray-800 font-medium menu-item-here:text-gray-900 menu-item-active:text-gray-900 menu-link-hover:text-gray-900"
                            >
                        Events
                      </span>
                        </a>
                    </div>

                  <!-- Public Profile -->
                  <div
                    class="menu-item"
                    data-menu-item-toggle="accordion"
                    data-menu-item-trigger="click"
                  >
                    <div
                      class="menu-link gap-2.5 py-2 px-2.5 rounded-md !menu-item-hover:bg-transparent !menu-item-here:bg-transparent"
                    >
                      <span
                        class="menu-icon items-start text-gray-400 text-lg menu-item-here:text-gray-900 menu-item-show:text-gray-900 menu-link-hover:text-gray-900"
                      >
                        <i class="ki-filled ki-profile-circle"></i>
                      </span>
                      <span
                        class="menu-title font-medium text-sm text-gray-700 menu-item-here:text-gray-900 menu-item-show:text-gray-900 menu-link-hover:text-gray-900"
                      >
                        Public Profile
                      </span>
                      <span
                        class="menu-arrow text-gray-400 menu-item-here:text-gray-400 menu-item-show:text-gray-800 menu-link-hover:text-gray-800"
                      >
                        <i
                          class="ki-filled ki-down text-3xs menu-item-show:hidden"
                        ></i>
                        <i
                          class="ki-filled ki-up text-3xs hidden menu-item-show:inline-flex"
                        ></i>
                      </span>
                    </div>
                    <div class="menu-accordion gap-px ps-7">
                      <!-- Profiles -->
                      <div
                        class="menu-item"
                        data-menu-item-toggle="accordion"
                        data-menu-item-trigger="click"
                      >
                        <div
                          class="menu-link py-2 px-2.5 rounded-md border border-transparent !menu-item-here:bg-transparent"
                        >
                          <span
                            class="menu-title text-2sm text-gray-800 menu-item-here:text-gray-900 menu-item-show:text-gray-900 menu-link-hover:text-gray-900"
                          >
                            Profiles
                          </span>
                        </div>
                        <div class="menu-accordion gap-px ps-2.5">
                          <div class="menu-item">
                            <a
                              class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                              href="html/demo10/public-profile/profiles/default.html"
                            >
                              <span
                                class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                              >
                                Default
                              </span>
                            </a>
                          </div>
                          <div class="menu-item">
                            <a
                              class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                              href="html/demo10/public-profile/profiles/creator.html"
                            >
                              <span
                                class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                              >
                                Creator
                              </span>
                            </a>
                          </div>
                          <div class="menu-item">
                            <a
                              class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                              href="html/demo10/public-profile/profiles/company.html"
                            >
                              <span
                                class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                              >
                                Company
                              </span>
                            </a>
                          </div>
                          <div class="menu-item">
                            <a
                              class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                              href="html/demo10/public-profile/profiles/nft.html"
                            >
                              <span
                                class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                              >
                                NFT
                              </span>
                            </a>
                          </div>
                          <div class="menu-item">
                            <a
                              class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                              href="html/demo10/public-profile/profiles/blogger.html"
                            >
                              <span
                                class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                              >
                                Blogger
                              </span>
                            </a>
                          </div>
                          <div class="menu-item">
                            <a
                              class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                              href="html/demo10/public-profile/profiles/crm.html"
                            >
                              <span
                                class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                              >
                                CRM
                              </span>
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- Works -->
                      <div class="menu-item">
                        <a
                          class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                          href="html/demo10/public-profile/works.html"
                        >
                          <span
                            class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                          >
                            Works
                          </span>
                        </a>
                      </div>

                      <!-- Teams -->
                      <div class="menu-item">
                        <a
                          class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                          href="html/demo10/public-profile/teams.html"
                        >
                          <span
                            class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                          >
                            Teams
                          </span>
                        </a>
                      </div>

                      <!-- Activity -->
                      <div class="menu-item">
                        <a
                          class="menu-link py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100"
                          href="html/demo10/public-profile/activity.html"
                        >
                          <span
                            class="menu-title text-2sm text-gray-800 menu-item-active:font-medium menu-item-active:text-gray-900 menu-link-hover:text-pgray-900"
                          >
                            Activity
                          </span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End of Sidebar menu-->
          <!-- Footer -->
          <!-- End of Footer -->
        </div>
        <!-- End of Sidebar -->
        <!-- Main -->
        <div
          class="flex flex-col grow lg:rounded-l-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border border-gray-300 dark:border-gray-200 lg:ms-[--tw-sidebar-width]"
        >
          <div
            class="flex flex-col grow lg:scrollable-y-auto lg:[scrollbar-width:auto] lg:light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] pt-5"
            id="scrollable_content"
          >
            <main class="grow" role="content">
              <!-- Toolbar -->
              <div class="pb-5">
                <!-- Container -->
                <div
                  class="container-fixed flex items-center justify-between flex-wrap gap-3"
                >
                  <div class="flex flex-col flex-wrap gap-1">
                    <h1 class="font-medium text-lg text-gray-900"></h1>
                    <div class="flex items-center gap-1 text-sm font-normal">
                      <a class="text-gray-700 hover:text-primary" href="#">
                        Home
                      </a>
                    </div>
                  </div>
                </div>
                <!-- End of Container -->
              </div>
              <!-- End of Toolbar -->
              <!-- Container -->
              <!-- End of Container -->
              @yield("content")
            </main>
            <!-- Footer -->
            @include("admin.partials.scripts")
            <!-- End of Footer -->
          </div>
        </div>
        <!-- End of Main -->
      </div>
      <!-- End of Wrapper -->
    </div>
    <!-- End of Base -->
    @include("admin.partials.modals")
    <!-- End of Page -->
    <!-- Scripts -->
    @include("admin.partials.scripts")
    <!-- End of Scripts -->
  </body>
</html>
