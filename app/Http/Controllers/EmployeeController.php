<?php

namespace App\Http\Controllers;

use App\Models\Correlation;
use App\Models\Employee;
use App\Models\Salle;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $employees = Employee::where('Etat','Actif')->get('*');
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salles = Salle::all();
        return view('employee.create', compact('salles'));
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
                'Prenom' => 'required',
                'Telephone' => 'required',
                'Adresse' => 'required',
                'Fonction' => 'required',
                'SalleActuelle' => 'required',
                'NumeroPPR' => 'required',
            ],
            [
                'required' => 'Le champs :attribute est obligatoire.'
            ]
        );

        //chof wach kayn chi wahed endo nfs nmra de tele ola numero ppr ola wach salle kayna ola la 
        $tele = Employee::where('Telephone', $request->Telephone)->get('*');
        $numero_ppr = Employee::where('NumeroPPR', $request->NumeroPPR)->get('*');
        $salle = Salle::where('Numero', $request->SalleActuelle)->get('*');

        if ($tele->count() != 0) {
            return redirect()->action([EmployeeController::class, 'create'])->with('error', 'Il se trouve déjà un employé avec le même numéro du téléphone. Le numéro du téléphone est unique.');
        }

        if ($numero_ppr->count() != 0) {
            return redirect()->action([EmployeeController::class, 'create'])->with('error', 'Il se trouve déjà un employé avec le même numéro PPR. Le numéro PPR est unique.');
        }

        if ($salle->count() == 0) {
            return redirect()->action([EmployeeController::class, 'create'])->with('error', 'Il n\'y a pas une salle avec le numéro saisi.');
        }


        $employee = new Employee();
        $employee->Nom = $request->Nom;
        $employee->Prenom = $request->Prenom;
        $employee->Telephone = $request->Telephone;
        $employee->Adresse = $request->Adresse;
        $employee->Fonction = $request->Fonction;
        $employee->NumeroPPR = $request->NumeroPPR;
        $employee->save();

        $correlation = new Correlation();
        $correlation->NumeroSalle = $request->SalleActuelle;
        $correlation->IDEmployee = $employee->id;
        $correlation->save();
        //Employee::create($request->all());

        return redirect()->action([EmployeeController::class, 'index'])->with('success', 'Employée inséré avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $salleActuelle = Correlation::where('IDEmployee', $employee->id)->where('DateDepart', null)->get('*')->first();
        $old_salles = Correlation::orderby('DateRejoindre', 'DESC')->where('IDEmployee', $employee->id)->where('DateDepart', '!=', null)->get('*');

        return view('employee.show', compact('employee', 'salleActuelle', 'old_salles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $salles = Salle::all();
        $salleActuelle = Correlation::where('IDEmployee', $employee->id)->where('DateDepart', null)->value('NumeroSalle');
        return view('employee.edit', compact('employee', 'salleActuelle', 'salles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate(
            [
                'Nom' => 'required',
                'Prenom' => 'required',
                'Telephone' => 'required',
                'Adresse' => 'required',
                'SalleActuelle' => 'required',
                'NumeroPPR' => 'required',
            ],
            [
                'required' => 'veuillez remplir le champ : :attribute.'
            ]
        );

        //chof wach kayn chi wahed endo nfs nmra de tele ola numero ppr ola wach salle kayna ola la 
        $tele = Employee::where('Telephone', $request->Telephone)->where('id','!=',$employee->id)->get('*');
        $numero_ppr = Employee::where('NumeroPPR', $request->NumeroPPR)->where('id','!=',$employee->id)->get('*');
        $salle = Salle::where('Numero', $request->SalleActuelle)->where('id','!=',$employee->id)->get('*');

        if ($tele->count() != 0) {
            return redirect()->back()->with('error', 'Il se trouve déjà un employé avec le même numéro du téléphone. Le numéro du téléphone est unique.');
        }

        if ($numero_ppr->count() != 0) {
            return redirect()->back()->with('error', 'Il se trouve déjà un employé avec le même numéro PPR. Le numéro PPR est unique.');
        }

        if ($salle->count() == 0) {
            return redirect()->back()->with('error', 'Il n\'y a pas une salle avec le numéro saisi.');
        }


        $employee->update($request->all());

        if ($request->SalleActuelle != Correlation::where('IDEmployee', $employee->id)->where('DateDepart', '=', null)->first()->NumeroSalle) {
            $correlation = new Correlation();
            $correlation->NumeroSalle = $request->SalleActuelle;
            $correlation->IDEmployee = $employee->id;
            Correlation::where('IDEmployee', $correlation->IDEmployee)->where('DateDepart', '=', null)->update(['DateDepart' => Carbon::now('Africa/Casablanca')]);
            $correlation->save();
        }

        return redirect()->action([EmployeeController::class, 'index'])->with('success', 'Employée modifié avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        Employee::where('id',$employee->id)->update(['Etat'=>'Parti']);

        Correlation::where('IDEmployee', $employee->id)->where('DateDepart', null)->update(['DateDepart' => Carbon::now('Africa/Casablanca'),'etat'=>'Parti']);

        return redirect()->action([EmployeeController::class, 'index'])->with('success', 'Employée supprimé avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supprimer($id)
    {
        $em = Employee::where('id', $id)->get('*')->first();
        return view('employee.delete', compact('em'));
    }
}
