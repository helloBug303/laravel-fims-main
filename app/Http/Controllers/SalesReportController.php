<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon; // For date manipulation

class SalesReportController extends Controller
{
    // Show the form for generating the sales report
    public function index()
    {   
        return view('sales.report');
    }

    // Process the sales report generation
    public function generateReport(Request $request)
    {
        // Validate the input dates
        $request->validate([
            'start-date' => 'required|date',
            'end-date' => 'required|date|after_or_equal:start-date',
        ]);

        // Fetch sales within the date range
        $sales = Sale::whereBetween('date', [$request->input('start-date'), $request->input('end-date')])
            ->get();

        // Check if there are any results
        if ($sales->isEmpty()) {
            return redirect()->route('sales.report.index')->with('error', 'No sales data found for the given date range.');
        }

        // Get the start and end dates from the request
        $startDate = $request->input('start-date');
        $endDate = $request->input('end-date');

        // Return the results to the view
        return view('sales.report_result', compact('sales', 'startDate', 'endDate'));
    }

    
    public function dailyReport(Request $request)
    {
        // Fetch sales for the daily report
        $date = $request->input('date');
        
        // Assuming you have a Sale model and a relationship between sales and date
        $sales = Sale::whereDate('date', $date)->get();

        // Return the report view with the data
        return view('sales.report_result', compact('sales'));
    }

    // Fetch monthly sales report
    public function monthlyReport(Request $request)
    {
        // Validate the input month and year
        $request->validate([
            'month' => 'required|date_format:Y-m', // Format should be Year-Month (e.g., 2025-04)
        ]);

        $month = $request->input('month'); // Get the month from input (e.g., '2025-04')

        // Fetch sales for the given month
        $sales = Sale::whereMonth('date', Carbon::parse($month)->month) // Get the month number
            ->whereYear('date', Carbon::parse($month)->year) // Get the year
            ->get();

        // Return the results to the view
        return view('sales.report_result', compact('sales', 'request'));
    }
}


