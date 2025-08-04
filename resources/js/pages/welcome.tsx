import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Props {
    stats?: {
        total_customers: number;
        active_customers: number;
        total_packages: number;
        active_packages: number;
        total_invoices: number;
        unpaid_invoices: number;
        total_revenue: number;
        monthly_revenue: number;
    };
    recent_customers?: Array<{
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
    recent_payments?: Array<{
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
    overdue_invoices?: Array<{
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

export default function Welcome({ stats, recent_customers, recent_payments, overdue_invoices }: Props) {
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
        <>
            <Head title="ISP Management System" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                {/* Header */}
                <header className="bg-white shadow-sm border-b">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <div className="flex justify-between items-center">
                            <div className="flex items-center space-x-3">
                                <div className="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold text-xl">🌐</span>
                                </div>
                                <div>
                                    <h1 className="text-2xl font-bold text-gray-900">ISP Manager</h1>
                                    <p className="text-sm text-gray-600">Internet Service Provider Management System</p>
                                </div>
                            </div>
                            <div className="flex space-x-3">
                                <Link href="/login">
                                    <Button variant="outline">Login</Button>
                                </Link>
                                <Link href="/register">
                                    <Button>Get Started</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="py-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 className="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                            🚀 Streamline Your ISP Operations
                        </h2>
                        <p className="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                            Complete management solution for Internet Service Providers. Handle customers, packages, billing, and payments all in one powerful platform.
                        </p>
                        <div className="mt-8">
                            <Link href="/register">
                                <Button size="lg" className="text-lg px-8 py-3">
                                    Start Managing Your ISP 🎯
                                </Button>
                            </Link>
                        </div>
                    </div>
                </section>

                {/* Stats Overview */}
                {stats && (
                    <section className="py-12 bg-white/50">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <h3 className="text-2xl font-bold text-center mb-8">📊 System Overview</h3>
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <Card>
                                    <CardHeader className="pb-3">
                                        <CardTitle className="text-2xl font-bold text-blue-600">
                                            {stats.total_customers}
                                        </CardTitle>
                                        <CardDescription>Total Customers</CardDescription>
                                    </CardHeader>
                                </Card>
                                <Card>
                                    <CardHeader className="pb-3">
                                        <CardTitle className="text-2xl font-bold text-green-600">
                                            {stats.active_customers}
                                        </CardTitle>
                                        <CardDescription>Active Customers</CardDescription>
                                    </CardHeader>
                                </Card>
                                <Card>
                                    <CardHeader className="pb-3">
                                        <CardTitle className="text-2xl font-bold text-purple-600">
                                            {stats.total_packages}
                                        </CardTitle>
                                        <CardDescription>Service Packages</CardDescription>
                                    </CardHeader>
                                </Card>
                                <Card>
                                    <CardHeader className="pb-3">
                                        <CardTitle className="text-2xl font-bold text-orange-600">
                                            {formatCurrency(stats.monthly_revenue)}
                                        </CardTitle>
                                        <CardDescription>This Month Revenue</CardDescription>
                                    </CardHeader>
                                </Card>
                            </div>
                        </div>
                    </section>
                )}

                {/* Features Section */}
                <section className="py-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h3 className="text-3xl font-bold text-center mb-12">✨ Key Features</h3>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center space-x-2">
                                        <span>👥</span>
                                        <span>Customer Management</span>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <ul className="space-y-2 text-gray-600">
                                        <li>• Register and manage customers</li>
                                        <li>• Track customer status</li>
                                        <li>• Subscription history</li>
                                        <li>• Customer service notes</li>
                                    </ul>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center space-x-2">
                                        <span>📦</span>
                                        <span>Service Packages</span>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <ul className="space-y-2 text-gray-600">
                                        <li>• Create internet packages</li>
                                        <li>• Set speeds and pricing</li>
                                        <li>• Package descriptions</li>
                                        <li>• Active/inactive status</li>
                                    </ul>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center space-x-2">
                                        <span>💰</span>
                                        <span>Billing System</span>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <ul className="space-y-2 text-gray-600">
                                        <li>• Automatic invoice generation</li>
                                        <li>• Payment tracking</li>
                                        <li>• Overdue notifications</li>
                                        <li>• Revenue reports</li>
                                    </ul>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </section>

                {/* Recent Activity */}
                {(recent_customers || recent_payments || overdue_invoices) && (
                    <section className="py-12 bg-white/50">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <h3 className="text-2xl font-bold text-center mb-8">📈 Recent Activity</h3>
                            <div className="grid lg:grid-cols-3 gap-6">
                                {/* Recent Customers */}
                                {recent_customers && recent_customers.length > 0 && (
                                    <Card>
                                        <CardHeader>
                                            <CardTitle>👋 New Customers</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-3">
                                                {recent_customers.map((customer) => (
                                                    <div key={customer.id} className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                                        <div>
                                                            <p className="font-medium">{customer.name}</p>
                                                            <p className="text-sm text-gray-600">{customer.service_package.name}</p>
                                                        </div>
                                                        <Badge className={getStatusColor(customer.status)}>
                                                            {customer.status}
                                                        </Badge>
                                                    </div>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                )}

                                {/* Recent Payments */}
                                {recent_payments && recent_payments.length > 0 && (
                                    <Card>
                                        <CardHeader>
                                            <CardTitle>💳 Recent Payments</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-3">
                                                {recent_payments.map((payment) => (
                                                    <div key={payment.id} className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                                        <div>
                                                            <p className="font-medium">{payment.customer.name}</p>
                                                            <p className="text-sm text-gray-600">{payment.invoice.invoice_number}</p>
                                                        </div>
                                                        <p className="font-bold text-green-600">
                                                            {formatCurrency(payment.amount)}
                                                        </p>
                                                    </div>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                )}

                                {/* Overdue Invoices */}
                                {overdue_invoices && overdue_invoices.length > 0 && (
                                    <Card>
                                        <CardHeader>
                                            <CardTitle>⚠️ Overdue Invoices</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-3">
                                                {overdue_invoices.map((invoice) => (
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
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                )}
                            </div>
                        </div>
                    </section>
                )}

                {/* CTA Section */}
                <section className="py-16 bg-blue-600 text-white">
                    <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                        <h3 className="text-3xl font-bold mb-4">
                            🎯 Ready to Manage Your ISP Business?
                        </h3>
                        <p className="text-xl mb-8 text-blue-100">
                            Join hundreds of ISPs using our platform to streamline operations and grow their business.
                        </p>
                        <div className="flex justify-center space-x-4">
                            <Link href="/register">
                                <Button size="lg" variant="secondary" className="text-lg px-8 py-3">
                                    Create Account
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button size="lg" variant="outline" className="text-lg px-8 py-3 text-white border-white hover:bg-white hover:text-blue-600">
                                    Sign In
                                </Button>
                            </Link>
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-8">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <p className="text-gray-400">
                            © 2024 ISP Manager. Built with Laravel & React.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}