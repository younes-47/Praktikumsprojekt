<?php

namespace App\Http\Controllers;

use App\Models\Correlation;
use App\Models\Employee;
use App\Models\Eqcorrelation;
use App\Models\Equipement;
use App\Models\Salle;
use Carbon\Carbon;
use Database\Factories\SalleFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salles = Salle::all();

        return view('salle.index', compact('salles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modeles = Eqcorrelation::orderby('Date_ajout','DESC')->select('Modele','Quantite_actuelle')->where('ID_emplacement',0)->where('Quantite_deplacee', 0)->where('Etat',null)->get('*')->unique('Modele');
        return view('salle.create',compact('modeles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'Nom' => 'required',
                'Numero' => 'required',
            ],
            [
                'required' => 'veuillez remplir le :attribute de la salle.'
            ]
        );

        //chof wach salle déja kayna
        $salle = Salle::where('Numero',$request->Numero)->get('*');
        if($salle->count() > 0){
            return redirect()->action([SalleController::class, 'create'])->with('error', 'Il se trouve déjà une salle avec le même numéro saisi. Le numéro de la salle est unique.');
        }

        if (!empty($request->Type)) {
            foreach ($request->Type as $key => $Type) {
                //créer ligne akhor f db fih stock jdid li ba9i f depot
                $stock_jdid = new Eqcorrelation();
                $stock_jdid->ID_emplacement = 0;
                $stock_jdid->Type = $Type;
                $stock_jdid->Modele = $request->Modele[$key];

                $stock_jdid->Quantite_actuelle = Eqcorrelation::orderby('Date_ajout', 'DESC')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                    ->where('Modele', '=', $request->Modele[$key])->where('Type', '=', $Type)->value('Quantite_actuelle') - $request->Stock[$key];


                //error hila kan quantité li baghi tzid l salle kbar mn dkchi li kayn f depot
                if ($stock_jdid->Quantite_actuelle < 0) {
                    return redirect()->action([SalleController::class, 'create'])->with('error', 'la quantité des equipements que vous voulez ajouter à la salle est supérieure de celle qui se trouvent dans le dépôt!');
                }

                $stock_jdid->Quantite_ajoute = 0;
                // $stock_jdid->Date_ajout = Eqcorrelation::orderby('Date_ajout', 'ASC')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                //     ->where('Modele', '=', $request->Modele[$key])->where('Type', '=', $Type)->value('Date_ajout');

                $stock_jdid->Date_ajout = Carbon::now('Africa/Casablanca');
                $stock_jdid->Quantite_deplacee = 0;



                $stock_jdid->save();

                //sauvgarder les équipements li kaynin daba f la salle f table eqcorrelation
                $equipements_salle = new Eqcorrelation();
                $equipements_salle->ID_emplacement = $request->Numero;
                $equipements_salle->Type = $Type;
                $equipements_salle->Modele = $request->Modele[$key];
                $equipements_salle->Quantite_ajoute = $request->Stock[$key];
                $equipements_salle->Quantite_actuelle = $equipements_salle->Quantite_actuelle + $request->Stock[$key];
                $equipements_salle->Quantite_deplacee = 0;
                $equipements_salle->save();


                //modifier stock l9dim dyal depot b3da
                DB::table('eqcorrelations')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                    ->where('Modele', '=', $request->Modele[$key])->where('Type', '=', $Type)
                    ->where('Quantite_actuelle', '>', $stock_jdid->Quantite_actuelle)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')->update(['Date_deplacement' => Carbon::now('Africa/Casablanca'), 'Quantite_deplacee' => $request->Stock[$key]]);
            }
            $salle = new Salle();
            $salle->Nom = $request->Nom;
            $salle->Numero = $request->Numero;
            $salle->save();
        } else {
            $salle = new Salle();
            $salle->Nom = $request->Nom;
            $salle->Numero = $request->Numero;
            $salle->save();
        }

        return redirect()->action([SalleController::class, 'index'])->with('success', 'Salle insérée avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Salle $salle)
    {
        $employees = Correlation::where('NumeroSalle', $salle->Numero)->where('DateDepart', null)->join('employees', 'correlations.IDemployee', '=', 'employees.id')->select('employees.Nom','employees.id','employees.Prenom' ,'employees.Telephone')->get('*');

        $equipements = Eqcorrelation::orderby('Date_ajout','DESC')->where('Etat',null)->where('ID_emplacement', $salle->Numero)
        ->where('Quantite_deplacee', 0)->where('Date_deplacement', null)->get('*')->unique('Modele');

        return view('salle.show', compact('salle', 'employees', 'equipements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Salle $salle)
    {
        $equipements = Eqcorrelation::orderby('Date_ajout','DESC')->where('Etat',null)->where('ID_emplacement', $salle->Numero)
        ->where('Quantite_deplacee', 0)->where('Date_deplacement', null)->get('*')->unique('Modele');

        $modeles = Eqcorrelation::orderby('Date_ajout','DESC')->select('Modele','Quantite_actuelle')
        ->where('ID_emplacement',0)->where('Quantite_deplacee', 0)->where('Etat',null)->get('*')->unique('Modele');
        
        return view('salle.edit', compact('salle', 'equipements','modeles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salle $salle)
    {
        $request->validate(
            [
                'Nom' => 'required',
                'Numero' => 'required',
            ],
            [
                'required' => 'veuillez remplir le nouveau :attribute de la salle.'
            ]
        );
        $salle->update(['Nom' => $request->Nom, 'Numero' => $request->Numero]);

/*
*
* 
*
* ajouti des equipements jdad l la salle
*
*
*
*/
        if (!empty($request->Type)) {
            foreach ($request->Type as $key => $Type) {

                //créer ligne akhor f db fih stock jdid li ba9i f depot
                $stock_jdid = new Eqcorrelation();
                $stock_jdid->ID_emplacement = 0;
                $stock_jdid->Type = $Type;
                $stock_jdid->Modele = $request->Modele[$key];
                //stock jdid li f depot howa stock l9dim na9is stock fel requete
                $stock_jdid->Quantite_actuelle = Eqcorrelation::orderby('Date_ajout', 'DESC')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                    ->where('Modele', '=', $request->Modele[$key])->where('Type', '=', $Type)->value('Quantite_actuelle') - $request->Stock[$key];



                //error hila kan quantité li baghi tzid l salle kbar mn dkchi li kayn f depot
                if ($stock_jdid->Quantite_actuelle < 0) {
                    return redirect()->back()->with('error', 'la quantité des equipements que vous voulez ajouter à la salle est supérieure de celle qui se trouvent dans le dépôt!');
                }

                $stock_jdid->Quantite_ajoute = -$request->Stock[$key];
                // $stock_jdid->Date_ajout = Eqcorrelation::orderby('Date_ajout', 'ASC')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                //     ->where('Modele', '=', $request->Modele[$key])->where('Type', '=', $Type)->value('Date_ajout');
                $stock_jdid->Date_ajout = Carbon::now('Africa/Casablanca');
                $stock_jdid->Quantite_deplacee = 0;



                $stock_jdid->save();

                //modifier stock l9dim dyal depot b3da
                DB::table('eqcorrelations')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                    ->where('Modele', '=', $request->Modele[$key])->where('Type', '=', $Type)
                    ->where('Quantite_actuelle', '>', $stock_jdid->Quantite_actuelle)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')->update(['Date_deplacement' => Carbon::now('Africa/Casablanca'), 'Quantite_deplacee' => $request->Stock[$key]]);


                //sauvgarder les équipements li kaynin daba f la salle f table eqcorrelation
                $equipements_salle = new Eqcorrelation();
                $equipements_salle->ID_emplacement = $request->Numero;
                $equipements_salle->Type = $Type;
                $equipements_salle->Modele = $request->Modele[$key];
                $equipements_salle->Quantite_ajoute = $request->Stock[$key];
                $equipements_salle->Quantite_actuelle = $equipements_salle->Quantite_actuelle + $request->Stock[$key];
                $equipements_salle->Quantite_deplacee = 0;
                $equipements_salle->save();
            }
        }



/*
*
* 
*
*modification dyal les equipements li déjà kaynin f la salle
*
*
*
*/


        if(!empty($request->Type_old)){

            foreach ($request->Stock_old as $key => $Stock_old) {
                $old_qte_salle = Eqcorrelation::where('ID_emplacement', $salle->Numero)->where('Date_deplacement', '=', null)
                    ->where('Modele', '=', $request->Modele_old[$key])
                    ->where('Type', '=', $request->Type_old[$key])
                    ->where('Quantite_deplacee', 0)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')->value('Quantite_actuelle');

                    if(($Stock_old - $old_qte_salle) == 0) { // hila mabdl walo f qte (resultat = 0)
    
                        continue;
        
                    }
                    elseif($Stock_old == 0){ //hila bgha ysupprimi equipement o rad stock = 0
                        /*
                            *
                            * updati stock dyal salle + modifi etat dyal les lignes l9dam (deleted)
                            *
                            */
                        $ligne_stock_old_salle = Eqcorrelation::where('ID_emplacement', $salle->Numero)->where('Date_deplacement', '=', null)
                        ->where('Modele', '=', $request->Modele_old[$key])
                        ->where('Type', '=', $request->Type_old[$key])
                        ->where('Quantite_deplacee', 0)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')->get('*')->first();
                        
                        $ligne_stock_old_salle->update(['Quantite_deplacee'=>$old_qte_salle,'Date_deplacement'=>Carbon::now('Africa/Casablanca'),'Etat'=>'deleted']);

                        $etat_9dima = Eqcorrelation::where('ID_emplacement', $salle->Numero)
                        ->where('Modele', '=', $request->Modele_old[$key])
                        ->where('Type', '=', $request->Type_old[$key])
                        ->get('*');
                        foreach($etat_9dima as $etat){
                            $etat->update(['Etat'=>'deleted']);
                        }
                        
    
                        /*
                            *
                            * ajouti ligne jdid fih stock jdid dyal depot (hit dak stock li tsupprima mn salle ghadi yrja3 l depot)
                            *
                            */
                            $stock_new_depot = new Eqcorrelation();
                            $stock_new_depot->Quantite_ajoute = $old_qte_salle;
                            //stock jdid = stock l9dim + stock li tzad
                            $stock_new_depot->Quantite_actuelle = Eqcorrelation::where('ID_emplacement',0)
                            ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                            ->where('Quantite_deplacee', 0)->where('Date_deplacement', '=', null)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')
                            ->value('Quantite_actuelle') + $old_qte_salle;
                            $stock_new_depot->Quantite_deplacee = 0;
                            $stock_new_depot->Type = $request->Type_old[$key];
                            $stock_new_depot->Modele = $request->Modele_old[$key];
                            $stock_new_depot->ID_emplacement = 0;
                            $stock_new_depot->save();
                    }
                elseif (($Stock_old - $old_qte_salle) < 0 && ($Stock_old - $old_qte_salle) != 0) { //Quantite dyal equipement na9sat mn salle
    
                    /*
                        *
                        * ajouti ligne fih stock jdid dyal depot (n9sat quantite fe salle = dkchi li n9as ghadi ytzad f depot)
                        *
                        */
    
                    $stock_new_depot = new Eqcorrelation();
                    $stock_new_depot->Quantite_ajoute = - ($Stock_old - $old_qte_salle); //hit howa negative ghanstockiw positive dyalo
                    //stock jdid = stock l9dim + quantite ajouté
                    $stock_new_depot->Quantite_actuelle = Eqcorrelation::where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                        ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                        ->where('Quantite_deplacee', 0)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')->value('Quantite_actuelle') + $stock_new_depot->Quantite_ajoute;
                    $stock_new_depot->Quantite_deplacee = 0;
                    $stock_new_depot->Type = $request->Type_old[$key];
                    $stock_new_depot->Modele = $request->Modele_old[$key];
                    $stock_new_depot->save();
    
                    /*
                        *
                        * update stock ligne li fih stock l9dim dyal salle
                        *
                        */
                    Eqcorrelation::orderby('Date_ajout', 'DESC')->where('ID_emplacement', $salle->Numero)->where('Date_deplacement', '=', null)
                        ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                        ->where('Quantite_deplacee', 0)->first()
                        ->update(['Quantite_deplacee' => $stock_new_depot->Quantite_ajoute, 'Date_deplacement' => Carbon::now('Africa/Casablanca')]);
    
                    /*
                        *
                        * ajouti ligne jdid dyal stock jdid li f salle
                        *
                        */
                    $stock_new_salle = new Eqcorrelation();
                    $stock_new_salle->Quantite_ajoute = -$stock_new_depot->Quantite_ajoute;
                    $stock_new_salle->Quantite_actuelle = Eqcorrelation::where('ID_emplacement', $salle->Numero) //stock jdid = stock l9dim + stock ajoute (stock ajoute rah negative)
                        ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                        ->orderby('Date_deplacement', 'DESC')->latest('Date_deplacement')->value('Quantite_actuelle') - $stock_new_depot->Quantite_ajoute;
                    $stock_new_salle->Quantite_deplacee = 0;
                    $stock_new_salle->Modele = $request->Modele_old[$key];
                    $stock_new_salle->Type = $request->Type_old[$key];
                    $stock_new_salle->ID_emplacement = $salle->Numero;
                    $stock_new_salle->save();
    
    
                } elseif (($Stock_old - $old_qte_salle) > 0 && ($Stock_old - $old_qte_salle) != 0) { /**** Quantite dyal equipement tzadt f salle ****/
    
                    //tester ba3da wach stock li kayn f depot suffisant bach yt2ajouta l salle
                    $temp = Eqcorrelation::where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                        ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                        ->where('Quantite_deplacee', 0)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')
                        ->value('Quantite_actuelle');
    
                        if(($temp -($Stock_old - $old_qte_salle) ) < 0){
                            return redirect()->back()->with('error', 'Vous ne pouvez pas augmenter la quantité des équipements qui se trouvent dans la salle par la quantité saisi. Stock insuffisant!');
                        }
    
    
                    /*
                        *
                        * update dyl stock l9dim dyal depot
                        *
                        */
                    Eqcorrelation::orderby('Date_ajout', 'DESC')->where('ID_emplacement', 0)->where('Date_deplacement', '=', null)
                        ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                        ->where('Quantite_deplacee', 0)->first()
                        ->update(['Quantite_deplacee' => ($Stock_old - $old_qte_salle), 'Date_deplacement' => Carbon::now('Africa/Casablanca')]);
    
                    /*
                        *
                        * ajouti ligne jdid fih stock jdid dyal depot
                        *
                        */
                    $stock_new_depot = new Eqcorrelation();
                    $stock_new_depot->Quantite_ajoute = - ($Stock_old - $old_qte_salle);
                    //stock l9dim dyal depot - qte li tzadt f salle
                    $stock_new_depot->Quantite_actuelle = Eqcorrelation::where('ID_emplacement', 0)->where('Modele', '=', $request->Modele_old[$key])
                        ->where('Type', '=', $request->Type_old[$key])->orderby('Date_deplacement', 'DESC')->latest('Date_deplacement')
                        ->value('Quantite_actuelle') - ($Stock_old - $old_qte_salle);
                    $stock_new_depot->Quantite_deplacee = 0;
                    $stock_new_depot->Modele = $request->Modele_old[$key];
                    $stock_new_depot->Type = $request->Type_old[$key];
                    $stock_new_depot->save();
                    /*
                        *
                        * ajouti ligne jdid fih stock jdid dyal salle
                        *
                        */
                    $stock_new_salle = new Eqcorrelation();
                    $stock_new_salle->Quantite_ajoute = ($Stock_old - $old_qte_salle);
                    //stock jdid = stock l9dim + stock li tzad
                    $stock_new_salle->Quantite_actuelle = Eqcorrelation::where('ID_emplacement',$salle->Numero)
                    ->where('Modele', '=', $request->Modele_old[$key])->where('Type', '=', $request->Type_old[$key])
                    ->where('Quantite_deplacee', 0)->where('Date_deplacement', '=', null)->orderby('Date_ajout', 'DESC')->latest('Date_ajout')
                    ->value('Quantite_actuelle') + ($Stock_old - $old_qte_salle);
                    $stock_new_salle->Quantite_deplacee = 0;
                    $stock_new_salle->Type = $request->Type_old[$key];
                    $stock_new_salle->Modele = $request->Modele_old[$key];
                    $stock_new_salle->ID_emplacement = $salle->Numero;
                    $stock_new_salle->save();
    
                }else{
                    return redirect()->back()->with('error', 'ma3rfna mandiro');
                }
            }
    
        }
        

        return redirect()->action([SalleController::class, 'index'])->with('success', 'Salle modifiée avec succès!');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salle $salle)
    {
        $employees = Correlation::where('DateDepart', '=', null)->where('NumeroSalle', $salle->Numero)->get('*');
        $equipements = Eqcorrelation::where('Date_deplacement', null)->where('Quantite_deplacee', 0)->where('ID_emplacement', '=', $salle->Numero)->where('Etat',null)->get('*');
        if ($employees->count() == 0 && $equipements->count() == 0) {
            $salle->delete();

            return redirect()->action([SalleController::class, 'index'])->with('success', 'Salle supprimée avec succès!');
        } else {
            return redirect()->action([SalleController::class, 'index'])->with('error', 'Vous ne pouvez pas supprimer cette salle: veuillez s\'assurer que la salle est vide des équipements et des employés ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supprimer($id)
    {
        $salle = Salle::where('id', $id)->get('*')->first();
        return view('salle.delete', compact('salle'));
    }
}
