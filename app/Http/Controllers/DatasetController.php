<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Topik;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class DatasetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Dataset::with('topik')->get();
            return response()->json(['data' => $data]);
        }

        $datasets = Dataset::with('topik')->paginate(10);
        return view('datasets.index', compact('datasets'));
    }

    public function create()
    {
        $topiks = Topik::all();
        return view('datasets.create', compact('topiks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_topik' => 'required',
            'nama_dataset' => 'required',
            'file' => 'required|mimes:xlsx,xls',
            'metadata_info' => 'nullable'
        ]);

        // Upload file
        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Read Excel file and convert to JSON
        $data = Excel::toArray([], $file);
        $jsonData = json_encode($data);

        Dataset::create([
            'id_topik' => $request->id_topik,
            'nama_dataset' => $request->nama_dataset,
            'meta_data_json' => $jsonData,
            'metadata_info' => $request->metadata_info,
            'files' => $filePath
        ]);

        return redirect()->route('datasets.index')->with('success', 'Dataset created successfully.');
    }

    public function edit(Dataset $dataset)
    {
        $topiks = Topik::all();
        return view('datasets.edit', compact('dataset', 'topiks'));
    }

    public function update(Request $request, Dataset $dataset)
    {
        $request->validate([
            'id_topik' => 'required',
            'nama_dataset' => 'required',
            'file' => 'nullable|mimes:xlsx,xls',
            'metadata_info' => 'nullable'
        ]);

        $data = [
            'id_topik' => $request->id_topik,
            'nama_dataset' => $request->nama_dataset,
            'metadata_info' => $request->metadata_info
        ];

        if ($request->hasFile('file')) {
            // Upload new file
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $data['files'] = $filePath;

            // Read Excel file and convert to JSON
            $dataExcel = Excel::toArray([], $file);
            $jsonData = json_encode($dataExcel);
            $data['meta_data_json'] = $jsonData;
        }

        $dataset->update($data);

        return redirect()->route('datasets.index')->with('success', 'Dataset updated successfully.');
    }

    public function destroy(Dataset $dataset)
    {
        $dataset->delete();
        return redirect()->route('datasets.index')->with('success', 'Dataset deleted successfully.');
    }
}