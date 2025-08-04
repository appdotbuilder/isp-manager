<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServicePackage;
use App\Models\Invoice;
use App\Models\Payment;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the ISP management dashboard.
     */
    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('status', 'active')->count(),
            'total_packages' => ServicePackage::count(),
            'active_packages' => ServicePackage::where('is_active', true)->count(),
            'total_invoices' => Invoice::count(),
            'unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
            'total_revenue' => Payment::sum('amount'),
            'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)
                                     ->whereYear('payment_date', now()->year)
                                     ->sum('amount'),
        ];

        $recent_customers = Customer::with('servicePackage')
                                  ->latest()
                                  ->limit(5)
                                  ->get();

        $recent_payments = Payment::with(['customer', 'invoice'])
                                 ->latest()
                                 ->limit(5)
                                 ->get();

        $overdue_invoices = Invoice::with('customer')
                                  ->where('status', 'unpaid')
                                  ->where('due_date', '<', now())
                                  ->limit(5)
                                  ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recent_customers' => $recent_customers,
            'recent_payments' => $recent_payments,
            'overdue_invoices' => $overdue_invoices,
        ]);
    }
}