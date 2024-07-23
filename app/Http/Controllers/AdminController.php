<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $headings = (new HeadingRowImport)->toArray($file);

        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());
        session(['uploaded_file_path' => $filePath]);

        return view('admin.upload', compact('headings'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'mapping' => 'required|array',
        ]);

        $filePath = session('uploaded_file_path');
        if (!$filePath) {
            return redirect('/admin')->with('error', 'No file uploaded');
        }

        $file = storage_path('app/' . $filePath);
        $mapping = $request->input('mapping');

        if (!file_exists($file)) {
            return redirect('/admin')->with('error', 'File not found');
        }

        Excel::import(new UsersImport($mapping), $file);

        Storage::delete($filePath);

        return redirect('/admin')->with('success', 'Users imported successfully.');
    }

    public function export(Request $request)
    {
        $columns = $request->input('columns', ['id', 'fullname', 'phone_number', 'email']);
        $users = User::select($columns)->get();

        return Excel::download(new UsersExport($users, $columns), 'users.xlsx');
    }
}
