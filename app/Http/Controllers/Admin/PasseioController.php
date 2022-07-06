<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Passeio as PasseioRequest;
use App\Models\Cidades;
use App\Models\Estados;
use App\Models\Passeio;
use App\Models\Pedido;
use App\Models\Roteiro;
use Illuminate\Http\Request;

class PasseioController extends Controller
{
    public function index()
    {
        $passeios = Passeio::orderBy('created_at', 'DESC')->paginate(25);
        $pedidos = Pedido::all();

        return view('admin.passeios.index',[
            'passeios' => $passeios,
            'pedidos' => $pedidos
        ]);
    }

    public function fetchCity(Request $request)
    {
        $data['cidades'] = Cidades::where("estado_id", $request->estado_id)->get(["cidade_nome", "cidade_id"]);
        return response()->json($data);
    }

    public function create()
    {
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->Available()->get();
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get();
        return view('admin.passeios.create',[
            'roteiros' => $roteiros,
            'estados' => $estados,
            'cidades' => $cidades
        ]);
    }

    public function store(PasseioRequest $request)
    {
        $passeioCreate = Passeio::create($request->all());
        $passeioCreate->fill($request->all());        
        
        return redirect()->route('passeios.edit', $passeioCreate->id)->with([
            'color' => 'success', 
            'message' => 'Passeio cadastrado com sucesso!'
        ]);        
    }

    public function edit($id)
    {
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->Available()->get();
        $passeio = Passeio::where('id', $id)->first();    
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get(); 
        
        return view('admin.passeios.edit', [
            'roteiros' => $roteiros,
            'passeio' => $passeio,
            'estados' => $estados,
            'cidades' => $cidades
        ]);
    }

    public function update(PasseioRequest $request, $id)
    {     
        $passeio = Passeio::where('id', $id)->first();
        $passeio->fill($request->all());

        $passeio->setVendaAttribute($request->venda);
        $passeio->setLocacaoAttribute($request->locacao);

        $passeio->setSegundaAttribute($request->segunda);
        $passeio->setTercaAttribute($request->terca);
        $passeio->setQuartaAttribute($request->quarta);
        $passeio->setQuintaAttribute($request->quinta);
        $passeio->setSextaAttribute($request->sexta);
        $passeio->setSabadoAttribute($request->sabado);
        $passeio->setDomingoAttribute($request->domingo);

        $passeio->save();      

        return redirect()->route('passeios.edit', [
            'id' => $passeio->id,
        ])->with(['color' => 'success', 'message' => 'Passeio atualizado com sucesso!']);
    } 

    public function passeioSetStatus(Request $request)
    {        
        $passeio = Passeio::find($request->id);
        $passeio->status = $request->status;
        $passeio->save();
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $passeiodelete = Passeio::where('id', $request->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        if(!empty($passeiodelete)){
            $json = "<b>$nome</b> você tem certeza que deseja excluir este passeio?";
            return response()->json(['error' => $json,'id' => $passeiodelete->id]);            
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }
    }
    
    public function deleteon(Request $request)
    {
        $passeiodelete = Passeio::where('id', $request->passeio_id)->first();  
        $postR = $passeiodelete->name;

        if(!empty($passeiodelete)){
            $passeiodelete->delete();           
        }
        return redirect()->route('passeios.index')->with([
            'color' => 'success', 
            'message' => 'O passeio '.$postR.' foi removido com sucesso!'
        ]);
    }
}
