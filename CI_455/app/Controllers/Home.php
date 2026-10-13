<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\EnergyModel;
use App\Models\NewsModel;
use App\Models\TenderModel;
use App\Models\VacancyModel;

class Home extends BaseController
{
	/*------------------------------------------------------------------------------------------------------------------------
    *   Display Home page
    */
	public function index()
	{
		helper('text');

		$energyModel = new EnergyModel();
		$tenderModel = new TenderModel();
		$newsModel = new NewsModel();
		$vacancyModel = new VacancyModel();    

		$data['energy'] = $energyModel->getLatestEnergyData();
		$data['latestTenders'] = $tenderModel->orderBy('created_at', 'DESC')->limit(3)->find();
		$data['vacancies'] = $vacancyModel->getPublicVacancies();
		$data['latestNews'] = $newsModel->select('news.*')
			->orderBy('created_at', 'DESC')
			->limit(6)
			->find();

		return view('home/home_page', $data);
	}

	/*------------------------------------------------------------------------------------------------------------------------
    *   Load Technical Paper
    */
	public function tech_paper()
	{
		return view('home/tech_paper');
	}

	/*------------------------------------------------------------------------------------------------------------------------
    *   Load Documents
    */
	public function documents()
	{
		return view('home/documents');
	}

	/*------------------------------------------------------------------------------------------------------------------------
    *   Load Internal Documents
    */
	public function internal_documents()
	{
		return view('home/internal_docs');
	}

	/*------------------------------------------------------------------------------------------------------------------------
    *   Load Organogram
    */
	public function organogram()
	{
		return view('home/organogram');
	}

	/*------------------------------------------------------------------------------------------------------------------------
    *   Load Governance Committee Page
    */
	public function governance()
	{
		return view('home/gov_com');
	}

	/*------------------------------------------------------------------------------------------------------------------------
    *   Load Energy graph
    */
	public function energy_graph()
	{
		return view('energydata/energy_graph');
	}

	public function report_public()
	{
		return view('reports/report_public');
	}

	public function vacancy()
	{
		return view('home/vacancy');
	}

	public function About()
	{
		return view('home/about_us');
	}
	public function Management()
	{
		return view('home/management_team');
	}
	public function BhutanApi()
	{
		return view('home/bhutan_api');
	}


	/*------------------------------------------------------------------------------------------------------------------------
    *   REMAP to prevent unauthorized method access
    */
	public function _remap($method, $param1 = null, $param2 = null)
	{
		if (method_exists($this, $method)) {
			return $this->$method($param1, $param2);
		} else {
			throw PageNotFoundException::forPageNotFound();
		}
	}
}
