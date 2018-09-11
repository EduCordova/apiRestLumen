<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //----------GET -> ALL AUTHORS
    public function showAllAuthors()
    {
      return response()->json(Author::all());
    }
    //---------GET -> ONLY ONE AUTHOR
    public function showOneAuthor($id)
    {
        return response()->json(Author::find($id));
    }
    //----------POST------
    public function create(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'location' => 'required|alpha'
        ]);
        //USANDO REQUEST Q NOSE Q PEDO :v
        $author = Author::create($request->all());
        //creamos una variable a la q le asignamos todo lo que resivimos en
        //request mediante el metodo create que creamos previamente en author
        return response()->json($author, 201);
    }
    //--------UPDATE
    public function update($id, Request $request)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());
        return response()->json($author,200);
    }
    public function delete($id)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted Succesfulle',200);
    }
}
