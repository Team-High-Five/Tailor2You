<?php
class Reports extends Controller {
    private $reportModel;

    public function __construct() {
        $this->reportModel = $this->model('M_Reports'); // Load the model
    }

    public function generate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $reportType = $_POST['reportType'];
            $dateRange = [
                'start' => $_POST['customRangeStart'] ?? date('Y-m-d', strtotime('-30 days')),
                'end' => $_POST['customRangeEnd'] ?? date('Y-m-d')
            ];

            // Validate inputs
            if (empty($reportType)) {
                flash('report_error', 'Please select a report type.');
                redirect('reports/generate');
            }

            // Generate the report based on the type
            switch ($reportType) {
                case 'sales':
                    $data = $this->reportModel->getSalesReport($dateRange);
                    break;
                case 'refund':
                    $data = $this->reportModel->getRefundReport($dateRange);
                    break;
                case 'userActivity':
                    $data = $this->reportModel->getUserActivityReport();
                    break;
                case 'inventory':
                    $data = $this->reportModel->getInventoryReport($dateRange);
                    break;
                default:
                    $data = [];
            }

            // Export the report as PDF
            $this->exportAsPDF($data);
        } else {
            redirect('reports/generate');
        }
    }

    private function exportAsPDF($data) {
        // Set headers to indicate a PDF file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="report.pdf"');

        // Start writing the PDF content
        $pdf = "%PDF-1.4\n";
        $pdf .= "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
        $pdf .= "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n";
        $pdf .= "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << >> >> endobj\n";

        // Add the content stream
        $content = "BT /F1 24 Tf 100 700 Td (Simple PDF Report) Tj ET\n"; // Title
        $y = 650; // Start position for table rows
        foreach ($data as $row) {
            $content .= "BT /F1 12 Tf 50 $y Td (" . implode(" ", $row) . ") Tj ET\n";
            $y -= 20; // Move down for the next row
        }

        $pdf .= "4 0 obj << /Length " . strlen($content) . " >> stream\n";
        $pdf .= $content;
        $pdf .= "endstream endobj\n";

        // Add the font object
        $pdf .= "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n";

        // Cross-reference table
        $xref = "xref\n0 6\n0000000000 65535 f \n0000000010 00000 n \n0000000060 00000 n \n0000000117 00000 n \n0000000215 00000 n \n0000000320 00000 n \n";
        $pdf .= $xref;

        // Trailer
        $pdf .= "trailer << /Size 6 /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . (strlen($pdf) - strlen($xref)) . "\n%%EOF";

        // Output the PDF
        echo $pdf;
    }
}