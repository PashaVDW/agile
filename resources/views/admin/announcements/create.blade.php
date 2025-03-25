@extends("admin.index")

@section("content")
  <div class="container max-w-lg mx-auto">
      <div class="mb-4">
          <a href="{{ route('announcements.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
              <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
              </svg>
              Terug naar overzicht
          </a>
      </div>
    <form
      method="POST"
      action="{{ route("announcements.store") }}"
      enctype="multipart/form-data"
    >
      @csrf
      <div class="flex justify-center items-center">
          <input name="image" class="file-input" type="file"/>
      </div>
      <div class="mb-5">
        <label
          for="title"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >
          Titel
          <span class="text-red-600">*</span>
        </label>
        <input
          type="text"
          id="title"
          name="title"
          placeholder="Vul de titel in"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          required
        />
      </div>
      <div class="mb-5">
        <label
          for="description"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >
          Omschrijving
          <span class="text-red-600">*</span>
        </label>
        <textarea
          id="description"
          name="description"
          placeholder="Voer hier de omschrijving in..."
          rows="6"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          required
        ></textarea>
      </div>
      <div class="mb-3">
        <button
          type="submit"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Aanmaken
        </button>
      </div>
    </form>
  </div>
@endsection
