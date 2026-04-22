<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
  public function index(): View
  {
    $books = Book::latest()->get();

    return view('books.index', compact('books'));
  }

  public function create(): View
  {
    return view('books.create');
  }

  public function store(Request $request): RedirectResponse
  {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'author' => 'required|string|max:255',
      'published_date' => 'required|date',
    ]);

    Book::create($validated);

    return redirect()->route('books.index')->with('success', 'Book added successfully.');
  }

  public function edit(Book $book): View
  {
    return view('books.edit', compact('book'));
  }

  public function update(Request $request, Book $book): RedirectResponse
  {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'author' => 'required|string|max:255',
      'published_date' => 'required|date',
    ]);

    $book->update($validated);

    return redirect()->route('books.index')->with('success', 'Book updated successfully.');
  }

  public function destroy(Book $book): RedirectResponse
  {
    $book->delete();

    return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
  }
}
