<?php

namespace App\Repositories;

use App\Models\Book;
use Auth;

class CommentRepository extends Repository
{
    public function createComment($book_id, array $data)
    {
        $book = Book::find($book_id);
        return $book->comments()->create($data);
    }

    public function findBookComments($book_id)
    {
      return $this->model->where('book_id', $book_id)->get();
    }

    public function getBooksComments()
    {
        return $this->model->whereHas('book', function ($query){
            return $query->where('user_id', Auth::user()->id);
        })
        ->where('user_id', '!=', Auth::user()->id)->get();
    }

    public function getUserComments(){
        return $this->model->whereHas('book', function ($query){
            return $query->where('user_id', '!=', Auth::user()->id);
        })
        ->where('user_id', Auth::user()->id)->get();
    }


}
