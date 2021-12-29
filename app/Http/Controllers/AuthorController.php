<?php

namespace App\Http\Controllers;
use Session;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author = Author::all();
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan "
            ]);
        return view('author.index', compact('author'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi data
$validated = $request->validate([
    'name' => 'required',


]);

$author =  new Author;
$author->name = $request->name;
$author->save();
return redirect()->route('author.index');

        $this->validate($request, ['name' => 'required|unique:author']);
        $author = Author::create($request->all());
        Session::flash("flash_notification", [
                        "level"=>"success",
                        "message"=>"Berhasil menyimpan"
                        ]);
        return redirect()->route('author.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $author = Author::findOrFail($id);
        return view('author.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        $author = Author::find($id);
        return view('author.edit')->with(compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        //validasi data
$validated = $request->validate([
    'name' => 'required',
]);

$author = Author::findOrFail($id);
$author->name = $request->name;
$author->save();
return redirect()->route('author.index');

         $this->validate($request, ['name' => 'required|unique:author,name,'. $id]);
         $author = Author::find($id);
         $author->update($request->only('name'));
         Session::flash("flash_notification", [
         "level"=>"success",
         "message"=>"Berhasil menyimpan"
         ]);
         return redirect()->route('author.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if(!Author::destroy($id)) return redirect()->back();
        Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"Penulis berhasil dihapus"
        ]);
        return redirect()->route('author.index');
    }
}
