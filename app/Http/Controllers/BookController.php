<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        return Book::with('student')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
        ]);

        $book = new Book();
        $book->student_id = $request->student_id;
        $book->title = $request->title;
        $book->save();

        return response()->json(['message' => 'Book created successfully', 'data' => $book], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->title = $request->title;
        $book->save();

        return response()->json(['message' => 'Book updated successfully', 'data' => $book], 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }

}
