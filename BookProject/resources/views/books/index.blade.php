<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

  {{-- Navbar --}}
  <nav class="bg-indigo-700 shadow-md">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
      <span class="text-white text-xl font-bold tracking-wide">📚 Book Library</span>
      <a href="{{ route('books.create') }}"
        class="bg-white text-indigo-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-indigo-50 transition">
        + Add New Book
      </a>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-6 py-10">

    {{-- Flash message --}}
    @if (session('success'))
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-300 text-green-800 px-5 py-3 rounded-lg">
      <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      {{ session('success') }}
    </div>
    @endif

    {{-- Header --}}
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-800">All Books</h1>
      <p class="text-gray-500 mt-1">Manage your book collection below.</p>
    </div>

    {{-- Table card --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
      @if ($books->isEmpty())
      <div class="text-center py-20 text-gray-400">
        <svg class="mx-auto w-14 h-14 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <p class="text-lg font-medium">No books found</p>
        <p class="text-sm mt-1">Get started by adding your first book.</p>
        <a href="{{ route('books.create') }}" class="inline-block mt-5 bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">Add Book</a>
      </div>
      @else
      <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider border-b">
          <tr>
            <th class="px-6 py-4">#</th>
            <th class="px-6 py-4">Title</th>
            <th class="px-6 py-4">Author</th>
            <th class="px-6 py-4">Published Date</th>
            <th class="px-6 py-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach ($books as $index => $book)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
            <td class="px-6 py-4 font-semibold text-gray-800">{{ $book->title }}</td>
            <td class="px-6 py-4 text-gray-600">{{ $book->author }}</td>
            <td class="px-6 py-4 text-gray-500">{{ $book->published_date->format('M d, Y') }}</td>
            <td class="px-6 py-4 text-right flex justify-end gap-2">
              <a href="{{ route('books.edit', $book->id) }}"
                class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">
                ✏️ Edit
              </a>
              <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                onsubmit="return confirm('Delete this book?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="inline-flex items-center gap-1 bg-red-50 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                  🗑 Delete
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </main>
</body>

</html>