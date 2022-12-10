<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; 
// use App\Models\Post;
use App\Models\Student;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Tugas Week 10
 */
Route::get('/', function () {
    return view('welcome');
});

//Inserting Data
Route::get('/students/THEPROCESS', function(){
    DB::insert("INSERT INTO students(nim, nama, prodi) VALUES(?,?,?)",
        ['55630', 'Michael D. Pratama', 'Informatika']);
});

//Reading Data
Route::get('/students/read', function(){
    $result = DB::select("SELECT * FROM students WHERE id = ?", [1]);
    foreach($result as $student){
        return $student->nama;
    }
    return $result;
});

//Updating Data
Route::get('/students/update', function(){
    $updated = DB::update("UPDATE students SET nama = ? WHERE id = ?", ["Michael D. Pratamaa", 1]);
    return $updated;
});

//Deleting Data
Route::get('/students/delete', function(){
    $deleted = DB::delete("DELETE FROM students WHERE id = ?", [1]);
    return $deleted;
});

//(ORM)
//Reading Data 
Route::get('/students/readORM', function(){
    $students = Student::all();
    $str = "";
    foreach($students as $student){
        $str .= $student->nim . " ". $student->nama . " " . $student->prodi . "<br />";
    }
    return $str;
});

//Find Data
Route::get('/students/find/{id}', function($id){
    $student = Student::find($id);
    return $student->nama;
});

//Reading/Finding with Constraints
Route::get('/students/findwhere', function(){
    $student = Student::where('prodi', 'Perhotelan')->orderBy('nim', 'asc')->take(2)->get();
    return $student;
});

//Inserting/Saving Data
Route::get('/students/basicinsert', function(){
    $student = new Student;
    $student->nim = '002';
    $student->nama = "Makido";
    $student->prodi = "Informatika";
    $student->save();
});

//Creating Data and Configuring Mass Assignment
Route::get('/students/create', function(){
    Student::create([
        'nim' => '024',
        'nama' => 'Marandoona',
        'prodi' => 'DKV'
    ]);
});

//Update Data
Route::get('/students/basicupdate', function(){
    $student = Student::find(2);
    $student->nim = '014';
    $student->nama = 'Nahidaa';
    $student->prodi = 'Sistem Informasi';
    $student->save();
});

//Updating with Eloquent
Route::get('/students/updateORM', function(){
    Student::where('id', 1)->update([
        'nim' => '55630',
        'nama' => 'Yugga',
        'prodi' => 'Teknik Elektro'
    ]);
});

//Deleting Data
Route::get('/students/deleteORM', function(){
    $student = Student::find(6);
    $student->delete();
});

//Deleting Data Cara ke-2
Route::get('/students/delete2ORM', function(){
    Student::destroy(3);
});

//Deleting Data Cara ke-3
Route::get('/students/delete3ORM', function(){
    Student::where('prodi', 'DKV')->delete();
});

//Soft Deleting/Trashing
Route::get('/students/softdelete', function(){
    Student::find(8)->delete();
});

//Retrieving Deleted/Trashed Record
Route::get('/students/readsoftdelete', function(){
    // $student = Student::find(9);
    // return $student;
    // $student = Student::withTrashed()->where('id', 9)->get();
    // return $student;
    // $student = Student::withTrashed()->get();
    // return $student;
    $student = Student::onlyTrashed()->get();
    return $student;
});

//Restoring Deleted/Trashed Records
Route::get('/students/restore', function(){
    Student::withTrashed()->where('id', 8)->restore();
});

//Deleting Record Permanently
Route::get('/students/forcedelete', function(){
    Student::onlyTrashed()->where('id', 8)->forceDelete();
});

/*
 * Latihan Modul Week 10
 */
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/read', function(){
//     $posts = Post::all();
//     $str = "";
//     foreach($posts as $post){
//         $str .= $post->title . "<br />";
//     }
//     return $str;
// });

// Route::get('/find/{id}', function($id){
//     $post = Post::find($id);
//     return $post->title;
// });

// Route::get('/findwhere', function(){
//     $posts = Post::where('is_admin', false)->orderBy('id', 'desc')->take(1)->get();
//     return $posts;
// });

// Route::get('/basicinsert', function(){
//     $post = new Post;
//     $post->title = "New Eloquent Title";
//     $post->content = "Wow Eloquent content is really cool";
//     $post->is_admin = true;
//     $post->save();
// });

// Route::get('/create', function(){
//     Post::create([
//         'title' => 'Title with Create Method',
//         'content' => 'Saya belajar banyak hari ini',
//         'is_admin' => false
//     ]);
// });

// Route::get('/basicupdate', function(){
//     $post = Post::find(5);
//     $post->title = 'Updated Eloquent Title';
//     $post->content = 'Updated Eloquent Content';
//     $post->save();
// });

// Route::get('/update', function(){
//     Post::where('id', 5)->where('is_admin', false)->update([
//         'title' => 'NEW PHP TITLE',
//         'content' => 'I love learning Laravel'
//     ]);
// });

// Route::get('/delete', function(){
//     $post = Post::find(5);
//     $post->delete();
// });

// Route::get('/delete2', function(){
//     Post::destroy([2,3]);
// });

// Route::get('/delete3', function(){
//     Post::where('is_admin', 0)->delete();
// });

// Route::get('/softdelete', function(){
//     Post::find(6)->delete();
// });

// Route::get('/readsoftdelete', function(){
//     // $post = Post::find(6);
//     // return $post;
//     // $post = Post::withTrashed()->where('id', 6)->get();
//     // return $post;
//     // $post = Post::withTrashed()->get();
//     // return $post;
//     $post = Post::onlyTrashed()->get();
//     return $post;
// });

// Route::get('/restore', function(){
//     Post::withTrashed()->where('id', 6)->restore();
// });

// Route::get('/forcedelete', function(){
//     Post::onlyTrashed()->where('is_admin', 0)->forceDelete();
// });


/*
 * DATABASE Raw SQL Queries
 */
// Route::get('/insert', function(){
//     DB::insert("INSERT INTO posts(title, content) VALUES(?,?)",
//         ['PHP with Laravel', 'Laravel is the berst thing that happen to PHP']);
// });

// Route::get('/read', function(){
//     $results = DB::select("SELECT * FROM posts WHERE id = ?", [1]);
//     // foreach($results as $post){
//     //     return $post->title;
//     // }
//     return $results;
// });

// ROUTE::get('/update', function(){
//     $updated = DB::update("UPDATE posts SET title = ? WHERE id = ?", ["Updated title", 1]);
//     return $updated;
// });

// ROUTE::get('/delete', function(){
//     $deleted = DB::delete("DELETE FROM posts WHERE id = ?", [1]);
//     return $deleted;
// });