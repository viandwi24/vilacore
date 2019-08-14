<?php

namespace App\Core\vilacoreSetting\Controllers;

use App\Core\BaseController;
use Illuminate\Http\Request;
use DotenvEditor;

class EnvController extends BaseController
{
    public function index()
    {
        $env = DotenvEditor::getContent();
        return view("vilacoreSetting::views.index", compact('env'));
    }

    public function save(Request $request)
    {
        $env = DotenvEditor::getContent();
        foreach($env as $key => $item)
        {
            if ($request->has($key) && isset($env[$key])) {
                $env[$key] = $request->input($key);
            } else {
                DotenvEditor::addData([$key => $item]);
                $env = DotenvEditor::getContent();
            }
        }

        $change = DotenvEditor::changeEnv($env);
        return redirect()->back()->with(['alert' => ['type' => 'success', 'text' => 'Env telah diperbarui.']]);
    }

    public function create(Request $request)
    {
        $request->validate(['key' => 'required', 'value' => 'required']);
        $change = DotenvEditor::addData([$request->key => $request->value]);
        return redirect()->back()->with(['alert' => ['type' => 'success', 'text' => 'Berhasil ditambahkan.']]);
    }

    public function delete(Request $request)
    {
        $request->validate(['key' => 'required']);
        $change = DotenvEditor::deleteData([$request->key]);
        return redirect()->back()->with(['alert' => ['type' => 'success', 'text' => 'Berhasil dihapus.']]);
    }

    public function backup()
    {
        return response()->download(base_path('.env'), '.env');
    }
}