<?php
class Reports extends Controller
{
    private $reportModel;

    public function __construct()
    {
        // Load the report model
        $this->reportModel = $this->model('M_Reports');
    }

    // Generate Report
    public function generate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data
            $data = [
                'reportType' => trim($_POST['reportType']),
                'customRangeStart' => trim($_POST['customRangeStart']),
                'customRangeEnd' => trim($_POST['customRangeEnd']),
                'outputFormat' => trim($_POST['outputFormat']),
                'errors' => []
            ];

            // Validate data
            if (empty($data['reportType'])) {
                $data['errors']['reportType'] = 'Please select a report type.';
            }
            if (empty($data['customRangeStart']) || empty($data['customRangeEnd'])) {
                $data['errors']['dateRange'] = 'Please select a valid date range.';
            }

            // If no errors, generate the report
            if (empty($data['errors'])) {
                $reportData = $this->reportModel->getReportData(
                    $data['reportType'], 
                    $data['customRangeStart'], 
                    $data['customRangeEnd']
                );

                if (empty($reportData)) {
                    die('No data found for the selected report type and date range.');
                }

                // Generate PDF report
                $this->generatePDFReport($reportData, $data['reportType']);
            } else {
                // Reload the page with errors
                $this->view('users/Admin/v_a_generateReports', $data);
            }
        } else {
            redirect('users/Admin/v_a_generateReports');
        }
    }

    // Generate PDF Report
    private function generatePDFReport($reportData, $reportType)
    {
        if (empty($reportData)) {
            die('No data available to generate the PDF report.');
        }

        require_once APPROOT . '/libraries/fpdf/fpdf.php';

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Title
        $pdf->Cell(0, 10, ucfirst($reportType) . ' Report', 0, 1, 'C');

        // Convert the first object to an array for headers
        $headers = array_keys((array)$reportData[0]);

        // Table headers
        $pdf->SetFont('Arial', 'B', 12);
        foreach ($headers as $header) {
            $pdf->Cell(40, 10, ucfirst($header), 1);
        }
        $pdf->Ln();

        // Table rows
        $pdf->SetFont('Arial', '', 12);
        foreach ($reportData as $row) {
            $rowArray = (array)$row; // Convert each object to an array
            foreach ($rowArray as $cell) {
                $pdf->Cell(40, 10, $cell, 1);
            }
            $pdf->Ln();
        }

        // Output the PDF
        $pdf->Output('D', ucfirst($reportType) . '_Report.pdf');
    }
}