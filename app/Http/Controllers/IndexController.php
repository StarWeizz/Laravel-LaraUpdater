<?php

namespace App\Http\Controllers;

use App\Extensions\UpdateManager;
use Exception;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    protected UpdateManager $updates;

    public function __construct(UpdateManager $updates) {
        $this->updates = $updates;
    }

    public function index()
    {
        return view('dashboard', [
            'lastVersion' => $this->updates->getLastVersion(true),
            'hasUpdate' => $this->updates->hasUpdate(),
            'isDownloaded' => $this->updates->isLastVersionDownloaded(),
        ]);
    }

    public function download(Request $request)
    {
        $update = $this->updates->getUpdate(true);

        if (! $this->updates->hasUpdate()) {
            return response()->json([
                'message' => 'vous avez déjà la dernière version',
            ]);
        }

        try {
            $this->updates->download($update);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }

        $request->session()->flash('success', 'Version installée!');

        return response()->noContent();
    }
}
