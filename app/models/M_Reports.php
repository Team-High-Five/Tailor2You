<?php
class M_Reports
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Fetch report data based on type and date range
    public function getReportData($reportType, $startDate, $endDate)
    {
        switch ($reportType) {
            case 'sales':
                $this->db->query('SELECT order_id, user_id, total_amount, created_at FROM orders WHERE created_at BETWEEN :startDate AND :endDate');
                break;
            case 'refund':
                $this->db->query('SELECT refund_id, user_id, amount, created_at FROM refunds WHERE created_at BETWEEN :startDate AND :endDate');
                break;
            case 'userActivity':
                $this->db->query('SELECT user_id, activity, created_at FROM user_activity WHERE created_at BETWEEN :startDate AND :endDate');
                break;
            case 'inventory':
                $this->db->query('
                    SELECT 
                        fabric_name, 
                        price_per_meter, 
                        stock, 
                        created_at 
                    FROM fabrics
                    WHERE created_at BETWEEN :startDate AND :endDate
                ');
                break;
            default:
                return [];
        }

        $this->db->bind(':startDate', $startDate);
        $this->db->bind(':endDate', $endDate);

        $result = $this->db->resultSet();

        // Debugging: Log the result
        error_log('Report Data: ' . print_r($result, true));

        return $result;
    }
}