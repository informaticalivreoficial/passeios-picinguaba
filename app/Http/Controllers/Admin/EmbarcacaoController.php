<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Embarcacao as EmbarcacaoRequest;
use App\Models\Configuracoes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use App\Support\Cropper;
use App\Models\Embarcacao;
use App\Models\EmbarcacaoGb;
use Illuminate\Http\Request;

class EmbarcacaoController extends Controller
{    
    public function index()
    {
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->paginate(25);        
        return view('admin.embarcacoes.index',[
            'embarcacoes' => $embarcacoes
        ]);
    }
    
    public function create()
    {
        return view('admin.embarcacoes.create');
    }
    
    public function store(EmbarcacaoRequest $request)
    {
        $embarcacaoCreate = Embarcacao::create($request->all());
        $embarcacaoCreate->fill($request->all());

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $embarcacaoGb = new EmbarcacaoGb();
                $embarcacaoGb->embarcacao_id = $embarcacaoCreate->id;
                $embarcacaoGb->path = $image->storeAs(env('AWS_PASTA') . 'embarcacoes/' . $embarcacaoCreate->id, Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $embarcacaoGb->save();
                unset($embarcacaoGb);
            }
        }
        
        return redirect()->route('embarcacoes.edit', $embarcacaoCreate->id)->with([
            'color' => 'success', 
            'message' => 'Embarcação cadastrada com sucesso!'
        ]);
    }
   
    public function edit($id)
    {
        $embarcacao = Embarcacao::where('id', $id)->first();    
        return view('admin.embarcacoes.edit', [
            'embarcacao' => $embarcacao
        ]);
    }
    
    public function update(EmbarcacaoRequest $request, $id)
    {
        $embarcacao = Embarcacao::where('id', $id)->first();
        $embarcacao->fill($request->all());

        $embarcacao->save();
        $embarcacao->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $embarcacaoImage = new EmbarcacaoGb();
                $embarcacaoImage->embarcacao_id = $embarcacao->id;
                $embarcacaoImage->path = $image->storeAs(env('AWS_PASTA') . 'embarcacoes/' . $embarcacao->id, Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $embarcacaoImage->save();
                unset($embarcacaoImage);
            }
        }

        return redirect()->route('embarcacoes.edit', [
            'id' => $embarcacao->id,
        ])->with(['color' => 'success', 'message' => 'Embarcação atualizada com sucesso!']);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = EmbarcacaoGb::where('id', $request->image)->first();
        $allImage = EmbarcacaoGb::where('embarcacao_id', $imageSetCover->embarcacao_id)->get();

        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }

        $imageSetCover->cover = true;
        $imageSetCover->save();

        $json = [
            'success' => true,
        ];

        return response()->json($json);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = EmbarcacaoGb::where('id', $request->image)->first();

        Storage::delete(env('AWS_PASTA') . $imageDelete->path);
        //Cropper::flush($imageDelete->path);
        $imageDelete->delete();

        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }
    
    public function embarcacaoSetStatus(Request $request)
    {        
        $embarcacao = Embarcacao::find($request->id);
        $embarcacao->status = $request->status;
        $embarcacao->save();
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $embarcacaodelete = Embarcacao::where('id', $request->id)->first();
        $embarcacaoGb = EmbarcacaoGb::where('embarcacao_id', $embarcacaodelete->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(Auth::user()->name);

        if(!empty($embarcacaodelete)){
            if(!empty($embarcacaoGb)){
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta embarcação? Existem imagens adicionadas e todas serão excluídas!";
                return response()->json(['error' => $json,'id' => $embarcacaodelete->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta embarcação?";
                return response()->json(['error' => $json,'id' => $embarcacaodelete->id]);
            }            
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }
    }
    
    public function deleteon(Request $request)
    {
        $embarcacaodelete = Embarcacao::where('id', $request->embarcacao_id)->first();  
        $imageDelete = EmbarcacaoGb::where('embarcacao_id', $embarcacaodelete->id)->first();
        $postR = $embarcacaodelete->name;

        if(!empty($embarcacaodelete)){
            if(!empty($imageDelete)){
                Storage::delete(env('AWS_PASTA') . $imageDelete->path);
                //Cropper::flush($imageDelete->path);
                $imageDelete->delete();
                Storage::deleteDirectory(env('AWS_PASTA') . 'embarcacoes/'.$embarcacaodelete->id);
                $embarcacaodelete->delete();
            }
            $embarcacaodelete->delete();
        }
        return redirect()->route('embarcacoes.index')->with([
            'color' => 'success', 
            'message' => 'A embarcações '.$postR.' foi removida com sucesso!'
        ]);
    }

    public function qrCode(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $embarcacaoQrCode = Embarcacao::where('slug', $request->slug)->first();
        if(!empty($embarcacaoQrCode)){
            $qrcode = 'data:image/png;base64,'.base64_encode(\QrCode::format('png')
                            ->merge($Configuracoes->getlogomarca(), .22, true)
                            ->errorCorrection('H')
                            ->size(300)
                            ->generate(route('web.embarcacao',['slug' => $embarcacaoQrCode->slug])));
            return response()->json(['qrcode' => $qrcode]);
        }else{
            return response()->json(['error' => 'Erro ao gerar QrCode!']);
        }
    }
    
}
