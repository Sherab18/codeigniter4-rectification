<?php

namespace App\Controllers;

use App\Models\CandidateModel;
use CodeIgniter\Controller;
use App\Models\EnergyModel;
use App\Models\TenderModel;
use App\Models\NewsModel;
use App\Models\ReportModel;
use App\Models\VacancyModel;
use App\Models\DocumentModel; // Use your existing model
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

class Publicdata extends Controller
{
	/*------------------------------------------------------------------------------------------------------------------------
	*	Constructor
	*/
	public $energyModel;
	public $newsModel;
	public $vacancyModel;
	public $candidateModel;
	public $reportModel;
	public $docModel; // Existing DocumentModel
	public function __construct()
	{
		helper(['form', 'date', 'database', 'url']);
		$this->energyModel = new EnergyModel();
		$this->newsModel = new NewsModel();
		$this->vacancyModel = new VacancyModel();
		$this->candidateModel = new CandidateModel();
		$this->reportModel = new ReportModel();
		$this->docModel = new DocumentModel(); // Initializing existing model
	}

	/*------------------------------------------------------------------------------------------------------------------------
	*	Energy Public Data
	*/
	//	Energy data in JSON format
	public function energy_data($param1 = Null, $param2 = Null,)
	{
		switch ($param1) {
			case 'generation_mwh':
				$title = 'Daily Total Electricity Generation in Bhutan (MWh)';
				$unit = 'MWh';
				break;
			case 'iex_import_mwh':
				$title = 'Daily Energy Import by Bhutan through IEX Exchange (MWh)';
				$unit = 'MWh';
				break;
			case 'iex_export_mwh':
				$title = 'Daily Energy Export by Bhutan through IEX Exchange (MWh)';
				$unit = 'MWh';
				break;
			case 'energy_met_mwh':
				$title = 'Daily Energy Met by Bhutan (MWh)';
				$unit = 'MWh';
				break;
			case 'energy_import_mwh':
				$title = 'Daily Energy Deficit/Import to Bhutan (MWh)';
				$unit = 'MWh';
				break;
			case 'energy_export_mwh':
				$title = 'Daily Energy Surplus/Export from Bhutan (MWh)';
				$unit = 'MWh';
				break;
			case 'peak_demand_mw':
				$title = 'Daily Peak Demand Met in Bhutan (MW)';
				$unit = 'MW';
				break;
			case 'demand_0900hrs_mw':
				$title = 'Daily Demand Met at 09:00 hrs in Bhutan (MW)';
				$unit = 'MW';
				break;
			case 'demand_1900hrs_mw':
				$title = 'Daily Demand Met at 19:00 hrs in Bhutan (MW)';
				$unit = 'MW';
				break;
			case 'peak_exchange_mw':
				$title = 'Daily Peak Export(+)/Import(-) of Power between Bhutan and India (MW)';
				$unit = 'MW';
				break;
			default:
				$title = 'Unknown Graph Selection';
				$unit = 'Unknown';
		}

		$f_date = $param2;
		$new_date = date_create($f_date);
		$t_date = date_format(date_add($new_date, date_interval_create_from_date_string('30 days')), 'Y-m-d');
		$records = $this->energyModel->where('date(r_date) >=', $f_date)->where('date(r_date) <=', $t_date)->orderBy('r_date', 'ASC')->findAll();
		if ($records) {
			foreach ($records as $row) {
				$data_raw[] = [
					'r_date' => $row['r_date'],
					'r_data' => $row[$param1],
				];
			}
		} else {
			$data_raw[] = [
				'r_date' => $f_date,
				'r_data' => 0,
			];
			$data_raw[] = [
				'r_date' => $t_date,
				'r_data' => 0,
			];
		}
		$data_out = [
			'title' => $title,
			'unit' => $unit,
			'data' => $data_raw,
		];
		echo json_encode($data_out);
	}
	public function latestEnergydata()
	{
		$energyModel = new EnergyModel();
		$data['energy'] = $energyModel->getLatestEnergyData();

		$data['animation'] = 'animate__animated animate__fadeInUp';


		return view('energydata/latestenergydata', $data);
	}
	public function tenderPublic()
	{
		$model = new TenderModel();
		$data['tenders'] = $model->getTenders();

		return view('admin/public_tender_form', $data);
	}
	public function show($id)
	{
		$model = new TenderModel();
		$tender = $model->find($id);

		if (!$tender) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tender not found');
		}

		// Process files field
		if ($tender['files'] && is_string($tender['files'])) {
			$decoded = json_decode($tender['files'], true);
			$tender['files'] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : [];
		} elseif (empty($tender['files'])) {
			$tender['files'] = [];
		}

		$data = [
			'tender' => $tender,
			'title' => $tender['title']
		];

		return view('admin/tender_details', $data);
	}
	public function downloadFile($tenderId, $fileIndex)
	{
		$model = new TenderModel();
		$tender = $model->find($tenderId);

		if (!$tender) {
			throw PageNotFoundException::forPageNotFound('Tender not found');
		}

		// Process files field
		if ($tender['files'] && is_string($tender['files'])) {
			$files = json_decode($tender['files'], true);
		} else {
			$files = $tender['files'] ?? [];
		}

		if (!isset($files[$fileIndex])) {
			throw PageNotFoundException::forPageNotFound('File not found');
		}

		$fileInfo = $files[$fileIndex];
		$filePath = WRITEPATH . 'uploads/tenders/' . basename($fileInfo['path']);

		if (!file_exists($filePath)) {
			throw PageNotFoundException::forPageNotFound('File does not exist');
		}

		$file = new File($filePath);

		return $this->response->download(
			$filePath,
			null,
			true
		)->setFileName($fileInfo['name']);
	}
	public function public_index()
	{
		$news = $this->newsModel
			->orderBy('created_at', 'DESC')
			->findAll();

		$data = [
			'news' => array_map(function ($item) {
				$item['attachments'] = $item['attachments'] ? json_decode($item['attachments'], true) : [];
				$item['excerpt'] = strip_tags(substr($item['content'], 0, 200));
				return $item;
			}, $news),
			'title' => 'Latest News & Announcements'
		];

		return view('news/public_index', $data);
	}
	public function public_view($id)
	{
		$news = $this->newsModel->find($id);

		if (!$news) {
			throw PageNotFoundException::forPageNotFound('News not found');
		}

		$news['attachments'] = $news['attachments'] ? json_decode($news['attachments'], true) : [];

		$data = [
			'news' => $news,
			'title' => $news['title']
		];

		return view('news/public_view', $data);
	}
	public function serve_attachment($fileName)
	{
		$filePath = WRITEPATH . 'uploads/news_attachments/' . $fileName;

		if (!file_exists($filePath)) {
			log_message('error', "Attachment not found: {$fileName}");
			return $this->response->setStatusCode(404);
		}

		$mime = mime_content_type($filePath) ?: 'application/octet-stream';
		$disposition = strpos($mime, 'image/') === 0 ? 'inline' : 'attachment';

		return $this->response
			->setContentType($mime)
			->setHeader('Content-Disposition', $disposition . '; filename="' . basename($filePath) . '"')
			->setBody(file_get_contents($filePath));
	}
	// Careers and Vacancies methods
	public function careers()
	{
		$data = [
			'title' => 'Careers & Opportunities',
			'vacancies' => $this->vacancyModel->getPublicVacancies(),
			'animation' => 'animate__animated animate__fadeInUp'
		];

		return view('vacancies/public_index', $data);
	}
	public function public_tab()
	{
		return view('vacancies/Vacancy_public_tab');
	}

	public function vacancy_detail($id)
	{
		$vacancy = $this->vacancyModel->getPublicVacancy($id);

		if (!$vacancy) {
			throw PageNotFoundException::forPageNotFound('Vacancy not found or no longer available');
		}

		$data = [
			'title' => $vacancy['title'],
			'vacancy' => $vacancy,
			'animation' => 'animate__animated animate__fadeInUp' // Add this line

		];

		return view('vacancies/public_detail', $data);
	}

	public function download_vacancy_attachment($id)
	{
		$vacancy = $this->vacancyModel->getPublicVacancy($id);

		if (!$vacancy || empty($vacancy['attachment_path'])) {
			throw PageNotFoundException::forPageNotFound('Attachment not found');
		}

		$filePath = WRITEPATH . str_replace('writable/', '', $vacancy['attachment_path']);

		if (!file_exists($filePath)) {
			throw PageNotFoundException::forPageNotFound('File does not exist');
		}

		return $this->response->download($filePath, null);
	}

	// Method for candidate apply
	public function apply($vacancyId)
	{
		$vacancy = $this->vacancyModel->find($vacancyId);
		if (!$vacancy || $vacancy['status'] !== 'open') {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$data = [
			'title' => 'Apply for ' . $vacancy['title'],
			'vacancy' => $vacancy,
			'validation' => \Config\Services::validation()
		];

		return view('candidates/apply', $data);
	}

	// Method for store the candidate application
	public function storeApplication()
	{
		// Enable CSRF protection
		if (!$this->request->is('post')) {
			return redirect()->back()->with('error', 'Invalid request method');
		}

		$rules = [
			'vacancy_id' => 'required|numeric',
			'first_name' => 'required|max_length[100]',
			'last_name' => 'required|max_length[100]',
			'email' => 'required|valid_email|max_length[255]',
			'phone' => 'max_length[50]',
			'cover_letter' => 'required',
			'resume' => 'uploaded[resume]|max_size[resume,1024]|ext_in[resume,pdf,doc,docx]'
		];

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		// Check if vacancy still exists and is open
		$vacancyId = $this->request->getPost('vacancy_id');
		$vacancy = $this->vacancyModel->find($vacancyId);
		if (!$vacancy || $vacancy['status'] !== 'open') {
			return redirect()->back()->withInput()->with('error', 'This vacancy is no longer available');
		}

		// Handle file upload
		$resume = $this->request->getFile('resume');
		if ($resume->isValid() && !$resume->hasMoved()) {
			$newName = $resume->getRandomName();
			$resume->move(WRITEPATH . 'uploads/resumes', $newName);

			$resumePath = 'writable/uploads/resumes/' . $newName;
		} else {
			return redirect()->back()->withInput()->with('error', 'Failed to upload resume');
		}

		// Save application
		$applicationData = [
			'vacancy_id' => $vacancyId,
			'first_name' => $this->request->getPost('first_name'),
			'last_name' => $this->request->getPost('last_name'),
			'email' => $this->request->getPost('email'),
			'phone' => $this->request->getPost('phone'),
			'cover_letter' => $this->request->getPost('cover_letter'),
			'resume_path' => $resumePath,
			'status' => 'applied',
		];

		if ($this->candidateModel->save($applicationData)) {
			return redirect()->to('publicdata/careers')->with('success', 'Application submitted successfully!. We will get back to you soon.');
		} else {
			// Add error logging
			log_message('error', 'Failed to save candidate application: ' . print_r($this->candidateModel->errors(), true));
			return redirect()->back()->withInput()->with('error', 'Failed to submit application. Please try again.');
		}
	}

	// Keep the vacancies method for backward compatibility or remove if not needed
	public function vacancies()
	{
		return $this->careers();
	}
	public function report_public()
	{
		$reportType = $this->request->getGet('report_type');
		$uploadDate = $this->request->getGet('upload_date');
		$glanceDate = $this->request->getGet('glance_date');   // Y-m-d, picked on the "System at a Glance" tab
		$tab        = $this->request->getGet('tab');           // 'glance' | 'reports'

		if (!is_string($glanceDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $glanceDate) || !strtotime($glanceDate)) {
			$glanceDate = null;
		}
		if (!in_array($tab, ['glance', 'reports'], true)) {
			$tab = (!empty($reportType) || !empty($uploadDate)) ? 'reports' : 'glance';
		}

		// ---- Reports table (filtered by type / upload date) ----
		$builder = $this->reportModel->orderBy('upload_date', 'DESC');
		if (!empty($reportType)) {
			$builder->where('report_type', $reportType);
		}
		if (!empty($uploadDate)) {
			$builder->where('DATE(upload_date)', $uploadDate);
		}
		$reports = $builder->findAll();

		// ---- System at a Glance: one dashboard per day that has an extracted daily report ----
		$rows = $this->reportModel
			->select('report_date')
			->where('report_type', 'daily')
			->where('summary_json IS NOT NULL', null, false)
			->where('report_date IS NOT NULL', null, false)
			->groupBy('report_date')
			->orderBy('report_date', 'DESC')
			->findAll();
		$availableDates = array_column($rows, 'report_date');          // newest first

		$selectedDate  = $glanceDate ?: ($availableDates[0] ?? null);  // default: latest day
		$glanceMissing = $glanceDate !== null && !in_array($glanceDate, $availableDates, true);

		$summary = null;
		$prevSummary = null;
		if ($selectedDate && !$glanceMissing) {
			$row = $this->reportModel
				->where('report_type', 'daily')
				->where('report_date', $selectedDate)
				->where('summary_json IS NOT NULL', null, false)
				->orderBy('upload_date', 'DESC')
				->first();
			$summary = $row ? json_decode($row['summary_json'], true) : null;
			if ($summary) {
				$summary['report_date'] = $selectedDate;

				// previous day's 09:00 figures for the "Change vs Previous Day" card
				$prev = $this->reportModel
					->where('report_type', 'daily')
					->where('report_date', date('Y-m-d', strtotime($selectedDate . ' -1 day')))
					->where('summary_json IS NOT NULL', null, false)
					->orderBy('upload_date', 'DESC')
					->first();
				$prevSummary = $prev ? json_decode($prev['summary_json'], true) : null;
			}
		}

		// nearest days that actually have a report, for the Previous / Next buttons
		$olderDate = $newerDate = null;
		if ($selectedDate) {
			foreach ($availableDates as $d) {
				if ($d < $selectedDate) { $olderDate = $d; break; }
			}
			foreach (array_reverse($availableDates) as $d) {
				if ($d > $selectedDate) { $newerDate = $d; break; }
			}
		}

		return view('reports/report_public', [
			'reports'        => $reports,
			'reportType'     => $reportType,
			'uploadDate'     => $uploadDate,
			'tab'            => $tab,
			'summary'        => $summary,
			'prevSummary'    => $prevSummary,
			'availableDates' => $availableDates,
			'selectedDate'   => $selectedDate,
			'requestedDate'  => $glanceDate ?? '',
			'glanceMissing'  => $glanceMissing,
			'olderDate'      => $olderDate,
			'newerDate'      => $newerDate,
			'latestDate'     => $availableDates[0] ?? null,
		]);
	}
	/**
	 * Display the COD documents for the public
	 * Route: publicdata/cod_public
	 */
	public function cod_public()
	{
		// Using your existing DocumentModel to fetch COD data with Station Names
		$data = [
			'title'     => 'Commercial Operation Declaration | BPSO',
			'documents' => $this->docModel->select('c_station_documents.*, c_stations.station as station_name')
				->join('c_stations', 'c_stations.id = c_station_documents.station_id')
				->where('c_station_documents.doc_type', 'COD')
				->orderBy('c_station_documents.created_at', 'DESC')
				->findAll(),
		];

		// Points to your file: app/Views/home/public_code.php
		return view('home/public_code', $data);
	}

	/**
	 * Public download function to match the link in your view
	 */
	public function download_cod($id)
	{
		$doc = $this->docModel->find($id);

		if (!$doc) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$filePath = WRITEPATH . 'uploads/cod_reports/' . $doc['file_path'];

		if (file_exists($filePath)) {
			return $this->response->download($filePath, null)->setFileName($doc['file_path']);
		}

		return redirect()->back()->with('error', 'File not found on server.');
	}
	/**
	 * View COD PDF in Browser
	 */
	public function view_cod($id)
	{
		$doc = $this->docModel->find($id);

		if (!$doc) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$filePath = WRITEPATH . 'uploads/cod_reports/' . $doc['file_path'];

		if (file_exists($filePath)) {
			// Get the file content
			$file = new \CodeIgniter\Files\File($filePath);
			$binary = readfile($filePath);

			return $this->response
				->setHeader('Content-Type', 'application/pdf')
				->setHeader('Content-Disposition', 'inline; filename="' . $doc['file_path'] . '"')
				->setBody($binary);
		}

		return redirect()->back()->with('error', 'File not found on server.');
	}

	/*------------------------------------------------------------------------------------------------------------------------
	* REMAP to prevent unauthorized method access
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
