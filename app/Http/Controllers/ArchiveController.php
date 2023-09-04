<?php

namespace App\Http\Controllers;

use App\Models\Correlation;
use App\Models\Employee;
use App\Models\Eqcorrelation;
use App\Models\Equipement;
use App\Models\Salle;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function selection(){
        
        return view('archive.selection');
    }

    public function employee(){

        $old_employees = Employee::where('Etat','Parti')->get('*');
        return view('archive.employees',compact('old_employees'));
    }

    public function historique($id){
        $nom_complet = Employee::find($id);
        $old_salles = Correlation::orderby('DateRejoindre', 'DESC')->where('IDEmployee', $id)->where('DateDepart', '!=', null)->get('*');
        return view('archive.employees-historique',compact('old_salles','nom_complet'));
    }

    public function equipements(){

        $old_equipements = Equipement::where('Etat','!=',null)->where('qte_distribue','!=',null)->get('*');
        return view('archive.equipements',compact('old_equipements'));
    }

    public function employe_restauration_page($id){
        $employee = Employee::where('id',$id)->get('*')->first();
        $salles = Salle::all();
        return view('archive.page-restauration-employe',compact('salles','employee'));
    }

    public function restaurer_employe(Request $request, $id){

        $request->validate(
            [
                'Salle_de_travaille' => 'required',
                
            ],
            [
                'required' => 'vous devez préciser la salle dans laquelle l\'employé poursuivra son travail !'
            ]
        );

        $correlation = new Correlation();
        $correlation->NumeroSalle = $request->Salle_de_travaille;
        $correlation->IDEmployee = $id;
        $correlation->etat = 'Restored';
        $correlation->save();

        Employee::where('id',$id)->where('Etat','Parti')->update(['Etat'=>'Actif']);


        return redirect()->action([ArchiveController::class, 'employee'])->with('success', 'Employée restauré avec succès! vous pouvez lui accéder dans la section des employés');
    }



    public function equipement_restauration_page($id){

        $equipement = Equipement::where('id',$id)->get('*')->first();

        return view('archive.page-restauration-equipement',compact('equipement'));
    }

    public function restaurer_equipement($id){

        $eq = Equipement::find($id);

        $eqcorrelation = new Eqcorrelation();
        $eqcorrelation->Type = $eq->Type;
        $eqcorrelation->Modele = $eq->Modele;
        $eqcorrelation->Quantite_actuelle = $eq->qte_distribue;
        $eqcorrelation->Quantite_ajoute = $eq->qte_distribue;
        $eqcorrelation->Quantite_deplacee = 0;
        $eqcorrelation->save();

        Equipement::where('id',$id)->where('Etat','deleted')->where('qte_distribue','!=',null)
        ->update(['Etat'=>null,'qte_distribue'=>null]);


        return redirect()->action([ArchiveController::class, 'equipements'])->with('success', 'Equipement restauré avec succès! vous pouvez l\'accéder dans la section des équipements');
    }
}
