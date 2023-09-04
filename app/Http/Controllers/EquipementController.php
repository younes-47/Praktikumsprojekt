<?php

namespace App\Http\Controllers;

use App\Models\Eqcorrelation;
use App\Models\Equipement;
use App\Models\Salle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipements = Equipement::all()->where('Etat',null);
        return view('equipement.index',compact('equipements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Type' => 'required',
            'Modele' => 'required',],
            ['required' => 'Le type et le modèle d\'équipement sont obligatoires.'
        ]);

        $modele = Equipement::where('Modele',$request->Modele)->get('*');
        if($modele->count() > 0){
            return redirect()->action([EquipementController::class, 'create'])->with('error', 'Il se trouve déjà un équipement avec le même modèle. Le modèle des équipements est unique.');
        }

        $equipement =new Equipement();
        if($request->Stock == null){
            $quantite = '0';
        }
        else{
            $quantite = $request->Stock;
        }
        if($request->Details == null){
            $equipement->Details = '';
        }
        else{
            $equipement->Details = $request->Details;
        }

        $equipement->Modele = $request->Modele;
        $equipement->Type = $request->Type;
        
        $equipement->save();

        $eqcorrelation = new Eqcorrelation();
        $eqcorrelation->ID_emplacement = 0;
        $eqcorrelation->Type = $equipement->Type;
        $eqcorrelation->Modele = $equipement->Modele;
        $eqcorrelation->Quantite_ajoute = $quantite;
        $eqcorrelation->Quantite_actuelle = $eqcorrelation->Quantite_actuelle + $quantite;
        $eqcorrelation->Quantite_deplacee = 0;

        $eqcorrelation->save();


        return redirect()->action([EquipementController::class, 'index'])->with('success','Equipement insérée avec succès!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Equipement $equipement)
    {
        $les_salles = Eqcorrelation::orderby('Date_ajout','DESC')->where('Type',$equipement->Type)->where('Modele',$equipement->Modele)
        ->where('Date_deplacement','=',null)->where('ID_emplacement','!=',0)->get('*')->unique('ID_emplacement');

        $stock = Eqcorrelation::orderby('Date_ajout','DESC')->where('Date_deplacement', null)
        ->where('Modele',$equipement->Modele)->where('Type',$equipement->Type)->where('Quantite_deplacee',0)
        ->where('ID_emplacement',0)->value('Quantite_actuelle');

        return view('equipement.show',compact('equipement','les_salles','stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipement $equipement)
    {
        $stock = Eqcorrelation::orderby('Date_ajout','DESC')->where('Date_deplacement', null)
        ->where('Modele',$equipement->Modele)->where('Type',$equipement->Type)->where('Quantite_deplacee',0)
        ->where('ID_emplacement',0)->value('Quantite_actuelle');

        return view('equipement.edit',compact('equipement','stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipement $equipement)
    {
        $request->validate([
            'Type' => 'required',
            'Modele' => 'required',],
            ['required' => 'Veuillez choisir le modèle de cette équipement. Si vous ne le savez pas saisir le type suivi par la marque.'
        ]);

        if($request->Stock == null){
            $request->Stock = '0';
        }

        if($request->Details == null){
            $request->Details = '';
        }

        $equipement->update($request->all());

        if($request->Stock != 0){
            $eqcorrelation = new Eqcorrelation();
            $eqcorrelation->ID_emplacement = 0;
            $eqcorrelation->Type = $request->Type;
            $eqcorrelation->Modele = $request->Modele;
            $stock_li_zado = $request->Stock - Eqcorrelation::orderby('Date_ajout','DESC')->where('ID_emplacement',0)->where('Type',$request->Type)->where('Modele',$request->Modele)->where('Quantite_deplacee',0)->where('Date_deplacement',null)->value('Quantite_actuelle');
            $eqcorrelation->Quantite_actuelle = Eqcorrelation::orderby('Date_ajout','DESC')->where('ID_emplacement',0)->where('Type',$request->Type)->where('Modele',$request->Modele)->where('Quantite_deplacee',0)->where('Date_deplacement',null)->value('Quantite_actuelle') + $stock_li_zado;
            $eqcorrelation->Quantite_ajoute = $stock_li_zado;
            $eqcorrelation->Quantite_Deplacee = 0;
            $eqcorrelation->save();
        }
        
        return redirect()->action([EquipementController::class, 'index'])->with('success','Equipement modifiée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipement $equipement)
    {
        

        $stock_deplacee_o_tarikh = Eqcorrelation::orderby('Date_ajout','DESC')->where('Quantite_deplacee',0)->where('Date_deplacement',null)
        ->get('*')->unique('ID_emplacement');

        $stock_distributed = 0;
            foreach($stock_deplacee_o_tarikh as $place){
                $place->update(['Quantite_deplacee'=>$place->Quantite_actuelle,'Date_deplacement'=>Carbon::now('Africa/Casablanca')]);
                $stock_distributed = $stock_distributed + $place->Quantite_actuelle ; 
            }

        
        //etat dyal historique kamla dyal had equippement khas twli deleted
        $etat = Eqcorrelation::where('Type', $equipement->Type)->where('Modele', $equipement->Modele);
        $etat->update(['Etat'=>'deleted']);

        Equipement::where('Type', $equipement->Type)->where('Modele', $equipement->Modele)->update(['Etat'=>'deleted','qte_distribue'=> $stock_distributed]);

        return redirect()->action([EquipementController::class, 'index'])->with('success','Equipement supprimée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supprimer($id)
    {
        $eq = Equipement::where('id',$id)->get('*')->first();
        return view('equipement.delete',compact('eq'));
    }
}
