<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Book</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

  {{-- Navbar --}}
  <nav class="bg-indigo-700 shadow-md">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="{{ route('books.index') }}" class="text-white text-xl font-bold tracking-wide">📚 Book Library</a>
      <a href="{{ route('books.index') }}" class="text-indigo-200 text-sm hover:text-white transition">← Back to list</a>
    </div>
  </nav>

  <main class="max-w-2xl mx-auto px-6 py-12">

    {{-- Breadcrumb --}}
    <p class="text-sm text-gray-500 mb-6">
      <a href="{{ route('books.index') }}" class="hover:text-indigo-600">Books</a>
      <span class="mx-2">/</span>
      <span class="text-gray-700 font-medium">Edit Book</span>
    </p>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-md p-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-1">Edit Book</h1>
      <p class="text-gray-500 text-sm mb-8">Update the details for <span class="font-medium text-gray-700">{{ $book->title }}</span>.</p>

      {{-- Validation errors --}}
      @if ($errors->any())
      <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-5 py-4">
        <p class="font-semibold mb-2">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1 text-sm">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form action="{{ route('books.update', $book->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('title') border-red-400 @enderror">
        </div>

        <div>
          <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
          <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('author') border-red-400 @enderror">
        </div>

        <div>
          <label for="published_date" class="block text-sm font-medium text-gray-700 mb-1">Published Date</label>
          <input type="date" id="published_date" name="published_date"
            value="{{ old('published_date', $book->published_date->format('Y-m-d')) }}" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('published_date') border-red-400 @enderror">
        </div>

        <div class="flex items-center justify-between pt-2">
          <a href="{{ route('books.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">Cancel</a>
          <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition">
            Update Book
          </button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>