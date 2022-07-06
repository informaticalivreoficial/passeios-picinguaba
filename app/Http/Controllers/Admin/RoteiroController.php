<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roteiro as RoteiroRequest;
use App\Models\Configuracoes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use App\Support\Cropper;
use App\Models\Roteiro;
use App\Models\RoteiroGb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoteiroController extends Controller
{
    public function index()
    {
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->paginate(25);
        return view('admin.roteiros.index',[
            'roteiros' => $roteiros
        ]);
    }

    public function create()
    {
        return view('admin.roteiros.create');
    }

    public function store(RoteiroRequest $request)
    {
        $roteiroCreate = Roteiro::create($request->all());
        $roteiroCreate->fill($request->all());

	$roteiroCreate->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $roteiroGb = new RoteiroGb();
                $roteiroGb->roteiro_id = $roteiroCreate->id;
                $roteiroGb->path = $image->storeAs('roteiros/' . $roteiroCreate->id, Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $roteiroGb->save();
                unset($roteiroGb);
            }
        }
        
        return redirect()->route('roteiros.edit', $roteiroCreate->id)->with([
            'color' => 'success', 
            'message' => 'Roteiro cadastrado com sucesso!'
        ]);        
    }

    public function edit($id)
    {
        $roteiro = Roteiro::where('id', $id)->first();    
        return view('admin.roteiros.edit', [
            'roteiro' => $roteiro
        ]);
    }

    public function update(RoteiroRequest $request, $id)
    {     
        $roteiro = Roteiro::where('id', $id)->first();
        $roteiro->fill($request->all());

        $roteiro->save();
        $roteiro->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $roteiroImage = new RoteiroGb();
                $roteiroImage->roteiro_id = $roteiro->id;
                $roteiroImage->path = $image->storeAs('roteiros/' . $roteiro->id, Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $roteiroImage->save();
                unset($roteiroImage);
            }
        }

        return redirect()->route('roteiros.edit', [
            'id' => $roteiro->id,
        ])->with(['color' => 'success', 'message' => 'Roteiro atualizado com sucesso!']);
    } 

    public function imageWatermark(Request $request)
    {
        //chama as configuracoes do site
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $roteiro = Roteiro::where('id', $request->id)->first();
        $roteiro->fill($request->all());
        $imagensGallery = RoteiroGb::where('roteiro_id', $request->id)->get();        
        if(!empty($Configuracoes->marcadagua) && !empty($imagensGallery)){
            foreach($imagensGallery as $imagem){   
                $img = Image::make(Storage::get($imagem->path));   
                /* insert watermark at bottom-right corner with 10px offset */
                $img->insert(Storage::get($Configuracoes->marcadagua), 'bottom-right', 10, 10);                
                $img->save(storage_path('app/public/'.$imagem->path));
                $img->encode('png'); 
            }
            $affected = DB::table('roteiro_gbs')->where('roteiro_id', '=', $request->id)->update(array('marcadagua' => 1));            
            unset($affected);
            $json = "Marca D´agua inserida com sucesso!";
            return response()->json(['success' => $json]);
        }else{
             $json = "Erro ao inserir a Marca D´agua!";
             return response()->json(['error' => $json]);
        }
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = RoteiroGb::where('id', $request->image)->first();
        $allImage = RoteiroGb::where('roteiro_id', $imageSetCover->roteiro_id)->get();

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
        $imageDelete = RoteiroGb::where('id', $request->image)->first();

        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();

        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }
    
    public function roteiroSetStatus(Request $request)
    {        
        $roteiro = Roteiro::find($request->id);
        $roteiro->status = $request->status;
        $roteiro->save();
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $roteirodelete = Roteiro::where('id', $request->id)->first();
        $roteiroGb = RoteiroGb::where('roteiro_id', $roteirodelete->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        if(!empty($roteirodelete)){
            if(!empty($roteiroGb)){
                $json = "<b>$nome</b> você tem certeza que deseja excluir este roteiro? Existem imagens adicionadas e todas serão excluídas!";
                return response()->json(['error' => $json,'id' => $roteirodelete->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir este roteiro?";
                return response()->json(['error' => $json,'id' => $roteirodelete->id]);
            }            
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }
    }
    
    public function deleteon(Request $request)
    {
        $roteirodelete = Roteiro::where('id', $request->roteiro_id)->first();  
        $imageDelete = RoteiroGb::where('roteiro_id', $roteirodelete->id)->first();
        $postR = $roteirodelete->name;

        if(!empty($roteirodelete)){
            if(!empty($imageDelete)){
                Storage::delete($imageDelete->path);
                Cropper::flush($imageDelete->path);
                $imageDelete->delete();
                Storage::deleteDirectory('roteiros/'.$roteirodelete->id);
                $roteirodelete->delete();
            }
            $roteirodelete->delete();
        }
        return redirect()->route('roteiros.index')->with([
            'color' => 'success', 
            'message' => 'O roteiro '.$postR.' foi removido com sucesso!'
        ]);
    }

    public function qrCode(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $roteiroQrCode = Roteiro::where('slug', $request->slug)->first();
        if(!empty($roteiroQrCode)){ 
            $qrcode = 'data:image/png;base64,'.base64_encode(\QrCode::format('png')
                            ->merge($Configuracoes->getlogomarca(), .22, true)
                            ->errorCorrection('H')
                            ->size(300)
                            ->generate(route('web.roteiro',['slug' => $roteiroQrCode->slug])));
            return response()->json(['qrcode' => $qrcode]);
        }else{
            return response()->json(['error' => 'Erro ao gerar QrCode!']);
        }
    }
}
