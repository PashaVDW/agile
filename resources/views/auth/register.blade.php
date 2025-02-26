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
    class="antialiased flex h-full text-base text-gray-700 dark:bg-coal-500"
  >
    @include("auth.partials.theme")

    <div
      class="flex items-center justify-center grow bg-center bg-no-repeat page-bg"
    >
      <div class="card max-w-[370px] w-full">
        <form
          action="{{ route("register") }}"
          class="card-body flex flex-col gap-5 p-10"
          id="sign_up_form"
          method="POST"
        >
          @csrf
          <div class="text-center mb-2.5">
            <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
              Sign up
            </h3>
            <div class="flex items-center justify-center">
              <span class="text-2sm text-gray-700 me-1.5">
                Already have an Account ?
              </span>
              <a class="text-2sm link" href="{{ route("login") }}">Sign In</a>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="border-t border-gray-200 w-full"></span>
            <span class="text-2xs text-gray-600 uppercase">or</span>
            <span class="border-t border-gray-200 w-full"></span>
          </div>

          <!-- Email Input -->
          <div class="flex flex-col gap-1">
            <label class="form-label text-gray-900">Email</label>
            @error("email")
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <input
              class="input @error("email") border-red-500 @enderror"
              name="email"
              placeholder="email@email.com"
              type="email"
              value="{{ old("email") }}"
              required
            />
          </div>

          <!-- Password Input -->
          <div class="flex flex-col gap-1">
            <label class="form-label font-normal text-gray-900">Password</label>
            @error("password")
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <div
              class="input @error("password") border-red-500 @enderror"
              data-toggle-password="true"
            >
              <input
                name="password"
                placeholder="Enter Password"
                type="password"
                required
              />
              <button
                class="btn btn-icon"
                data-toggle-password-trigger="true"
                type="button"
              >
                <i
                  class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"
                ></i>
                <i
                  class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"
                ></i>
              </button>
            </div>
          </div>

          <!-- Confirm Password Input -->
          <div class="flex flex-col gap-1">
            <label class="form-label font-normal text-gray-900">
              Confirm Password
            </label>
            @error("password_confirmation")
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <div
              class="input @error("password_confirmation") border-red-500 @enderror"
              data-toggle-password="true"
            >
              <input
                name="password_confirmation"
                placeholder="Re-enter Password"
                type="password"
                required
              />
              <button
                class="btn btn-icon"
                data-toggle-password-trigger="true"
                type="button"
              >
                <i
                  class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"
                ></i>
                <i
                  class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"
                ></i>
              </button>
            </div>
          </div>

          <button
            class="btn btn-primary flex justify-center grow"
            type="submit"
          >
            Sign up
          </button>
        </form>
      </div>
    </div>
    <!-- End of Page -->

    <!-- Scripts -->
    <script src="assets/js/core.bundle.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
    <!-- End of Scripts -->
  </body>
</html>
