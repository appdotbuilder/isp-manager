import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Props {
    stats: {
        total_customers: number;
        active_customers: number;
        total_packages: number;
        active_packages: number;
        total_invoices: number;
        unpaid_invoices: number;
        total_revenue: number;
        monthly_revenue: number;
    };
    recent_customers: Array<{
        id: number;
        name: string;
        email: string;
        status: string;
        service_package: {
            name: string;
            speed: string;
            price: number;
        };
        connection_date: string;
    }>;
    recent_payments: Array<{
        id: number;
        amount: number;
        payment_date: string;
        payment_method: string;
        customer: {
            name: string;
        };
        invoice: {
            invoice_number: string;
        };
    }>;
    overdue_invoices: Array<{
        id: number;
        invoice_number: string;
        amount: number;
        due_date: string;
        customer: {
            name: string;
        };
    }>;
    [key: string]: unknown;
}

export default function Dashboard({ stats, recent_customers, recent_payments, overdue_invoices }: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    };

    const formatDate = (date: string) => {
        return new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }).format(new Date(date));
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'active':
                return 'bg-green-100 text-green-800';
            case 'inactive':
                return 'bg-gray-100 text-gray-800';
            case 'suspended':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <AppShell>
            <Head title="ISP Dashboard" />
            
            <div className="space-y-8">
                {/* Header */}
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">🌐 ISP Dashboard</h1>
                        <p className="text-gray-600">Manage your Internet Service Provider operations</p>
                    </div>
                    <div className="flex space-x-3">
                        <Link href="/customers/create">
                            <Button>Add Customer</Button>
                        </Link>
                        <Link href="/service-packages/create">
                            <Button variant="outline">Add Package</Button>
                        </Link>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-2xl font-bold text-blue-600">
                                {stats.total_customers}
                            </CardTitle>
                            <CardDescription>Total Customers</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-gray-600">
                                {stats.active_customers} active customers
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-2xl font-bold text-green-600">
                                {formatCurrency(stats.monthly_revenue)}
                            </CardTitle>
                            <CardDescription>This Month Revenue</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-gray-600">
                                Total: {formatCurrency(stats.total_revenue)}
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-2xl font-bold text-purple-600">
                                {stats.total_packages}
                            </CardTitle>
                            <CardDescription>Service Packages</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-gray-600">
                                {stats.active_packages} active packages
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-3">
                            <CardTitle className="text-2xl font-bold text-red-600">
                                {stats.unpaid_invoices}
                            </CardTitle>
                            <CardDescription>Unpaid Invoices</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-gray-600">
                                Total: {stats.total_invoices} invoices
                            </p>
                        </CardContent>
                    </Card>
                </div>

                {/* Quick Actions */}
                <Card>
                    <CardHeader>
                        <CardTitle>⚡ Quick Actions</CardTitle>
                        <CardDescription>Common tasks and shortcuts</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <Link href="/customers">
                                <Button variant="outline" className="w-full h-16 flex flex-col">
                                    <span className="text-2xl mb-1">👥</span>
                                    <span>Customers</span>
                                </Button>
                            </Link>
                            <Link href="/service-packages">
                                <Button variant="outline" className="w-full h-16 flex flex-col">
                                    <span className="text-2xl mb-1">📦</span>
                                    <span>Packages</span>
                                </Button>
                            </Link>
                            <Link href="/invoices">
                                <Button variant="outline" className="w-full h-16 flex flex-col">
                                    <span className="text-2xl mb-1">📄</span>
                                    <span>Invoices</span>
                                </Button>
                            </Link>
                            <Link href="/payments">
                                <Button variant="outline" className="w-full h-16 flex flex-col">
                                    <span className="text-2xl mb-1">💳</span>
                                    <span>Payments</span>
                                </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>

                {/* Recent Activity */}
                <div className="grid lg:grid-cols-3 gap-6">
                    {/* Recent Customers */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center justify-between">
                                <span>👋 New Customers</span>
                                <Link href="/customers">
                                    <Button variant="ghost" size="sm">View All</Button>
                                </Link>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3">
                                {recent_customers.length > 0 ? (
                                    recent_customers.map((customer) => (
                                        <div key={customer.id} className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <p className="font-medium">{customer.name}</p>
                                                <p className="text-sm text-gray-600">{customer.service_package.name}</p>
                                                <p className="text-xs text-gray-500">{formatDate(customer.connection_date)}</p>
                                            </div>
                                            <Badge className={getStatusColor(customer.status)}>
                                                {customer.status}
                                            </Badge>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No recent customers</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Recent Payments */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center justify-between">
                                <span>💳 Recent Payments</span>
                                <Link href="/payments">
                                    <Button variant="ghost" size="sm">View All</Button>
                                </Link>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3">
                                {recent_payments.length > 0 ? (
                                    recent_payments.map((payment) => (
                                        <div key={payment.id} className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <p className="font-medium">{payment.customer.name}</p>
                                                <p className="text-sm text-gray-600">{payment.invoice.invoice_number}</p>
                                                <p className="text-xs text-gray-500">{formatDate(payment.payment_date)}</p>
                                            </div>
                                            <p className="font-bold text-green-600">
                                                {formatCurrency(payment.amount)}
                                            </p>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No recent payments</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Overdue Invoices */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center justify-between">
                                <span>⚠️ Overdue Invoices</span>
                                <Link href="/invoices">
                                    <Button variant="ghost" size="sm">View All</Button>
                                </Link>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3">
                                {overdue_invoices.length > 0 ? (
                                    overdue_invoices.map((invoice) => (
                                        <div key={invoice.id} className="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                            <div>
                                                <p className="font-medium">{invoice.customer.name}</p>
                                                <p className="text-sm text-gray-600">{invoice.invoice_number}</p>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-bold text-red-600">
                                                    {formatCurrency(invoice.amount)}
                                                </p>
                                                <p className="text-xs text-red-500">
                                                    Due: {formatDate(invoice.due_date)}
                                                </p>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No overdue invoices</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppShell>
    );
}