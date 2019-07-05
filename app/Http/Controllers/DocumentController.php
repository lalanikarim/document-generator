<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PhpParser\Comment\Doc;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $documents = Document::all();
        return View("document.index")->with(compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return View("document.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $document = new Document();
        $document->name = $request->name;
        $document->file = $request->file('template')->store('templates');
        $document->active = true;

        $document->save();

        return redirect(route('get-documents'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
        return View("document.show")->with(compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }

    public function launch(Request $request, Document $document)
    {
        $disk = Storage::disk('local');
        $process = new Process(['zint','--mirror','--notext','--batch','-i',$request->datafile->path()]);
        $disk->deleteDirectory($document->id);
        $disk->makeDirectory($document->id);
        $path = $disk->path($document->id);
        $process->setWorkingDirectory($path);
        $process->run();

        if(!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }

        $data = file_get_contents($request->datafile->path());

        $lines = explode(PHP_EOL,$data);

        $dom = new \DOMDocument();
        $root = $dom->createElement('document');

        $dom->appendChild($root);
        foreach ($lines as $line) {
            if(strlen(trim($line)) > 0) {
                $tag = $dom->createElement('tag');
                $id = $dom->createAttribute('id');
                $id->value = trim($line);
                $tag->appendChild($id);
                $root->appendChild($tag);
            }
        }

        $dom->save($path . "/data.xml");

        $disk->put($document->id . "/data.txt",$data);

        $fop = env('FOP_HOME') . '/fop';
        $process = new Process([$fop,'--noconfig','-xsl',$disk->path($document->file),'-xml',$path . "/data.xml",$path . "/output.pdf"]);
        $process->setEnv(['JAVA_HOME' => env('JAVA_HOME'),'FOP_HOME' => env( 'FOP_HOME')]);

        $process->run();

        if(!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }

        $originalName = $request->datafile->getClientOriginalName();
        $originalName = rtrim($originalName,'.');
        $extension = $request->datafile->getClientOriginalExtension();
        if(strlen($extension) > 0 && strlen($originalName) > strlen($extension) + 1)
        {
            $originalName = substr($originalName,0,strlen($originalName) - strlen($extension) - 1);
        }
        return response()->download($path . "/output.pdf",$originalName . ".pdf")->deleteFileAfterSend();
    }
}
